# Sistema de órdenes de servicio

[![Pruebas](https://github.com/checho13-dev/sistema-ordenes-servicio/actions/workflows/pruebas.yml/badge.svg)](https://github.com/checho13-dev/sistema-ordenes-servicio/actions/workflows/pruebas.yml)

Aplicación web para gestionar clientes, equipos y órdenes de servicio técnico. Proyecto personal de Sergio Esteban Bello Gómez, inspirado en su experiencia de soporte en Ubaté. La demostración utiliza datos ficticios.

## Recorrido de una reparación

1. Inicia sesión y registra un cliente con sus datos de contacto.
2. Asocia un equipo al cliente mediante su tipo, marca, modelo y número de serie.
3. Abre una orden con la falla reportada y la fecha de ingreso. Durante la atención puedes actualizar el diagnóstico, el costo estimado en pesos colombianos, el estado y la fecha de entrega.

Los tres módulos permiten listar, buscar, crear, consultar, editar y eliminar registros. Las listas conservan la búsqueda al cambiar de página. Cada eliminación solicita confirmación. Si existen equipos asociados al cliente u órdenes asociadas al equipo, se conserva el registro y se informa el motivo.

## Tecnologías

| Componente | Versión |
| --- | --- |
| PHP | 8.3 o posterior dentro de la rama 8.x; desarrollo con 8.4 |
| Laravel y Blade | 13.43.0 |
| MySQL | 8.4 LTS |
| Bootstrap | 5.3.8 |
| Vite | 7.3.8 |
| PHPUnit | 12.5.44 |

## Instalación local

Requisitos: Git, PHP con PDO MySQL, PDO SQLite (pruebas locales), Mbstring y XML, Composer 2, MySQL 8.4 y Node.js 22.12+ o 24 con npm.

1. Clona el proyecto e instala las dependencias de PHP.

   ```bash
   git clone https://github.com/checho13-dev/sistema-ordenes-servicio.git
   cd sistema-ordenes-servicio
   composer install
   ```

2. Crea la configuración local y genera la clave de la aplicación.

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   En PowerShell puedes copiar el archivo con `Copy-Item .env.example .env`.

3. Crea la base desde tu cliente MySQL y otorga a tu usuario local permisos sobre ella.

   ```sql
   CREATE DATABASE ordenes_servicio CHARACTER SET utf8mb4;
   ```

   En `.env`, establece `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3306` y `DB_DATABASE=ordenes_servicio`. Completa `DB_USERNAME` y `DB_PASSWORD` con los datos de tu instalación.

4. Ejecuta las migraciones, carga los ejemplos y crea tu cuenta de operador. El comando solicita la contraseña sin mostrarla.

   ```bash
   php artisan migrate --seed
   php artisan operador:crear
   ```

5. Compila los estilos y el JavaScript e inicia la aplicación.

   ```bash
   npm install
   npm run build
   php artisan serve
   ```

   Abre <http://127.0.0.1:8000> e ingresa con la cuenta que creaste.

## Pruebas

Una vez completada la instalación, ejecuta:

```bash
php artisan test
```

La suite local usa SQLite en memoria. Verifica el ciclo completo de los tres módulos, el acceso autenticado, el inicio y cierre de sesión, las relaciones que impiden eliminar registros, la validación de órdenes y la paginación con búsqueda. El flujo de [integración continua](.github/workflows/pruebas.yml) ejecuta las pruebas con una base MySQL exclusiva para el trabajo de CI.

## Modelo de datos

| Registro padre | Registro dependiente | Relación | Al intentar eliminar el padre |
| --- | --- | --- | --- |
| Cliente | Equipo | Uno a muchos mediante `equipos.cliente_id` | Si conserva equipos, se rechaza la eliminación y se informa el motivo. |
| Equipo | Orden | Uno a muchos mediante `ordenes.equipo_id` | Si conserva órdenes, se rechaza la eliminación y se informa el motivo. |

Cada orden identifica un equipo y almacena el diagnóstico, el costo y el estado vigente. Consulta las [migraciones](database/migrations/) y los [modelos de Eloquent](app/Models/).

## Limitaciones y próximos pasos

- El sistema guarda el estado vigente de la orden. Incorporar una bitácora permitiría consultar quién cambió cada estado y cuándo.
- Todos los operadores autenticados pueden modificar registros. Los permisos por rol permitirían separar recepción, diagnóstico y administración.
- El enum valida los cinco estados admitidos. Una regla de transición permitiría, por ejemplo, exigir que una orden esté lista antes de marcarla como entregada.

## Decisiones técnicas

1. **Una orden pertenece al equipo.** El cliente se obtiene a través del equipo. Así una orden no puede apuntar a un cliente distinto del propietario registrado.
2. **La base protege los registros relacionados.** Las claves foráneas restringen las eliminaciones aunque coincidan dos solicitudes. Los controladores traducen la restricción en un mensaje para el operador.
3. **Un enum define los cinco estados.** El formulario y la validación comparten `EstadoOrden`: recibido, en diagnóstico, en reparación, listo y entregado.
4. **El diagnóstico puede completarse después.** Falla y fecha de ingreso se exigen al abrir la orden. El costo usa un decimal de dos posiciones y la fecha de entrega, cuando se informa, debe ser igual o posterior al ingreso.
5. **Sesiones de Laravel y operadores locales.** El formulario usa Auth, protección CSRF y limitación de intentos. El alta de operadores es interactiva y el seeder solo crea datos de demostración.

## Estructura del proyecto

| Ruta | Responsabilidad |
| --- | --- |
| `routes/web.php` y `routes/console.php` | Rutas del panel y alta de operadores |
| `app/Http/Controllers/` y `app/Http/Requests/` | Acciones CRUD, autenticación y validación |
| `app/Models/` y `app/Enums/` | Relaciones de Eloquent y estados de las órdenes |
| `database/` | Migraciones, factories y seeder |
| `resources/views/` | Formularios, listados, fichas y plantilla Blade en español |
| `tests/Feature/GestionTest.php` | Pruebas de los flujos HTTP |

## Capturas de pantalla

Los espacios para las vistas de clientes, equipo y orden están en [docs/screenshots/](docs/screenshots/README.md).
