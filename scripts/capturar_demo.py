import os, subprocess, time, urllib.request, secrets, sqlite3, tempfile
from pathlib import Path
from playwright.sync_api import sync_playwright

php = "php"
with tempfile.TemporaryDirectory() as tmp:
    db = Path(tmp) / "demo.sqlite"
    db.touch()
    env = {
        **os.environ,
        "DB_CONNECTION": "sqlite",
        "DB_DATABASE": str(db),
        "SESSION_DRIVER": "file",
        "CACHE_STORE": "array",
        "APP_DEBUG": "false",
    }
    subprocess.run(
        [php, "artisan", "migrate", "--seed", "--force"],
        env=env,
        check=True,
        stdout=subprocess.DEVNULL,
    )
    pw = secrets.token_urlsafe(24)
    hashed = subprocess.check_output(
        [
            php,
            "-r",
            "echo password_hash(trim(stream_get_contents(STDIN)), PASSWORD_BCRYPT);",
        ],
        input=pw.encode(),
    ).decode()
    with sqlite3.connect(db) as c:
        c.execute(
            "insert into users (name,email,password) values(?,?,?)",
            ("Operador de demostración", "demo@example.invalid", hashed),
        )
        for i in range(1, 6):
            c.execute(
                "update clientes set nombre=?, documento=?, telefono=?, correo=?, direccion=? where id=?",
                (
                    f"Cliente de muestra {i:02}",
                    f"DEMO-{i:03}",
                    "Sin línea asignada",
                    f"demo{i}@example.invalid",
                    "Dirección ficticia",
                    i,
                ),
            )
        c.execute(
            "update equipos set tipo='Portátil', marca='Marca de muestra', modelo='Serie de demostración', numero_serie='DEMO-EQ-001' where id=1"
        )
        c.execute(
            "update ordenes set falla_reportada='El equipo se apaga al iniciar.', diagnostico='Conector de alimentación intermitente.', costo_estimado=85000, fecha_ingreso='2026-11-12',fecha_entrega='2026-11-14', estado='entregado' where id=1"
        )
    proc = subprocess.Popen(
        [php, "artisan", "serve", "--host=127.0.0.1", "--port=8187", "--no-reload"],
        env=env,
        stdout=subprocess.DEVNULL,
        stderr=subprocess.DEVNULL,
        start_new_session=True,
    )
    import signal

    try:
        for _ in range(50):
            try:
                urllib.request.urlopen("http://127.0.0.1:8187/login", timeout=1)
                break
            except OSError:
                time.sleep(0.2)
        with sync_playwright() as p:
            browser = p.chromium.launch(channel="chrome", args=["--no-sandbox"])
            page = browser.new_page(
                viewport={"width": 1120, "height": 650}, device_scale_factor=1
            )
            host = "http://127.0.0.1:8187"
            page.goto(host + "/login")
            page.locator("#email").fill("demo@example.invalid")
            page.locator("#password").fill(pw)
            page.get_by_role("button", name="Ingresar").click()
            page.wait_for_url("**/ordenes")
            for url, name, needle in [
                ("clientes?q=muestra", "clientes", "DEMO-005"),
                ("equipos/1", "equipo", "DEMO-EQ-001"),
                ("ordenes/1", "orden", "entregado"),
            ]:
                page.goto(host + "/" + url, wait_until="networkidle")
                page.get_by_text(needle, exact=True).wait_for()
                page.screenshot(path="docs/screenshots/" + name + ".png")
            browser.close()
    finally:
        os.killpg(proc.pid, signal.SIGTERM)
