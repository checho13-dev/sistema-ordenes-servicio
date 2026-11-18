# Capturas de la consola de servicio técnico

Chrome capturó la aplicación Laravel en ejecución. Las tres imágenes proceden de la [misma sesión de demostración](https://github.com/checho13-dev/sistema-ordenes-servicio/actions/runs/44397986168).

| Archivo | Contenido |
| --- | --- |
| [clientes.png](clientes.png) | Búsqueda por «muestra» con identificadores DEMO y sin números telefónicos asignados. |
| [equipo.png](equipo.png) | Cliente de muestra, tipo, marca, modelo y serie DEMO-EQ-001. |
| [orden.png](orden.png) | Falla, diagnóstico, importe en COP, fechas y estado del mismo equipo. |

El [script de captura](../../scripts/capturar_demo.py) crea una base SQLite temporal, ejecuta las migraciones y el seeder, asigna identificadores ficticios a los registros visibles e inicia sesión con una cuenta desechable. Abre las páginas de la aplicación en localhost y guarda los PNG. El [flujo de capturas](../../.github/workflows/capturas.yml) permite repetir la operación en GitHub Actions.
