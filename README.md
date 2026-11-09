<div align="center">

# SUSALUD
### Sistema de gestión de atención médica

**Una plataforma web para organizar la información del paciente y dar seguimiento al proceso de atención médica.**

![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Base_de_datos-4479A1?logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-Interfaz-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-Estilos-1572B6?logo=css3&logoColor=white)
![Estado](https://img.shields.io/badge/Estado-En_desarrollo-0E9F6E)

</div>

---

## Acerca del proyecto

**SUSALUD** es una aplicación web desarrollada en PHP y MySQL que permite gestionar información relacionada con pacientes, historias clínicas y atenciones médicas. Su propósito es centralizar los registros y facilitar el seguimiento de la información generada durante la atención.

El sistema cuenta con autenticación de usuarios y una interfaz de gestión desde la que se accede a los principales procesos.

## Panel principal

El dashboard presenta indicadores calculados directamente desde la base de datos:

- Pacientes registrados.
- Atenciones médicas.
- Diagnósticos registrados.
- Tratamientos registrados.
- Actividad de atenciones de los últimos siete días.
- Listado de las atenciones más recientes.
- Accesos rápidos a los procesos frecuentes.

## Funcionalidades implementadas

| Módulo | Funcionalidad |
|---|---|
| Acceso al sistema | Inicio y cierre de sesión; validación de credenciales. |
| Pacientes | Registro, listado y búsqueda por DNI, nombres o apellidos. |
| Historia clínica | Creación automática al registrar un paciente y generación de ficha imprimible. |
| Atenciones médicas | Registro de anamnesis, examen físico y plan de trabajo. |
| Triaje | Registro de peso, talla, IMC, presión arterial, temperatura, saturación de oxígeno y observaciones. |
| Diagnósticos | Registro de diagnósticos presuntivos y definitivos con referencia CIE-10. |
| Tratamientos | Registro del tipo de tratamiento y detalle de medicamentos o insumos, dosis, vía, frecuencia y duración. |
| Dashboard | Indicadores generales, actividad semanal y atenciones recientes. |

> El alcance descrito corresponde a las funcionalidades identificadas en el código fuente del repositorio. No representa una certificación clínica ni sustituye los procesos de validación y seguridad necesarios para un entorno sanitario real.

## Tecnologías

- **PHP:** lógica del servidor y procesamiento de formularios.
- **MySQL:** almacenamiento relacional.
- **MySQLi:** conexión y consultas preparadas a la base de datos.
- **HTML5:** estructura de las vistas.
- **CSS3:** estilos y diseño adaptable.
- **JavaScript:** interacciones de interfaz, como el cálculo del IMC.

## Estructura del proyecto

```text
SUSALUD/
├── assets/
│   └── styles.css
├── atenciones/
│   ├── guardar_atenciones.php
│   └── nueva.php
├── config/
│   ├── app.php
│   └── conexion.php
├── detalle_tratamiento/
│   ├── guardar.php
│   └── registrar.php
├── diagnosticos/
│   ├── guardar.php
│   └── registrar.php
├── historia_clinica/
│   └── imprimir.php
├── login/
│   ├── login.php
│   ├── logout.php
│   └── validar.php
├── pacientes/
│   ├── buscar.php
│   ├── guardar.php
│   ├── listar.php
│   └── registrar.php
├── tratamientos/
│   ├── guardar.php
│   ├── registrar.php
│   └── ver.php
├── triaje/
│   ├── guardar.php
│   └── registrar.php
├── index.php
├── medico.php
├── seguridad.php
└── test.php
```

## Requisitos para ejecutar localmente

- PHP 8 o superior (recomendado).
- MySQL o MariaDB.
- Apache (por ejemplo, mediante XAMPP).
- Navegador web.

## Instalación

1. Clona el repositorio dentro del directorio web de Apache:

   ```bash
   git clone URL_DEL_REPOSITORIO
   ```

2. Coloca la carpeta del proyecto con el nombre `SUSALUD` dentro de `htdocs` si utilizas XAMPP.

3. Crea una base de datos MySQL llamada `susalud`.

4. Configura los datos de conexión en `config/app.php`:

   ```php
   $conexion = new mysqli('localhost', 'root', '', 'susalud');
   ```

5. Verifica que la estructura de tablas requerida por el sistema exista en la base de datos. **Este repositorio no incluye un volcado SQL de la base de datos**, por lo que se debe incorporar o importar el esquema correspondiente antes de ejecutar la aplicación.

6. Inicia Apache y MySQL desde XAMPP.

7. Abre la aplicación:

   ```text
   http://localhost/SUSALUD/
   ```

## Flujo general de atención

```text
Inicio de sesión
      |
      v
Panel principal
      |
      v
Registro / búsqueda de paciente
      |
      v
Historia clínica
      |
      v
Nueva atención médica
      |
      +------> Triaje
      |
      +------> Diagnóstico (CIE-10)
      |
      +------> Tratamiento
      |
      v
Consulta e impresión de ficha médica
```

## Consideraciones

- No subir contraseñas reales, credenciales ni datos personales o clínicos de pacientes al repositorio.
- Configurar las credenciales de la base de datos mediante variables de entorno antes de desplegar el sistema en un servidor público.
- Revisar y completar las medidas de seguridad, autorización por roles, protección CSRF, auditoría y respaldo antes de utilizar información clínica real.
- La ruta base está configurada actualmente como `/SUSALUD` en `config/app.php`; debe ajustarse si cambia el nombre o la ubicación de despliegue.

---

<div align="center">

**SUSALUD** · Proyecto de desarrollo de software

</div>
