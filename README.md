#🎬 Proyecto_Videoclub_Pablo_Ismael

Proyecto educativo basado en un videoclub. Este proyecto ha contado con el apoyo de inteligencia artificial (IA) para generar explicaciones, resolver dudas técnicas y redactar este README.

## 📖 Descripción general

Este proyecto simula el funcionamiento de un videoclub, permitiendo gestionar soportes audiovisuales (como cintas de vídeo, DVDs y videojuegos), clientes y alquileres.

El proyecto se desarrolla de manera incremental, aplicando conceptos de Programación Orientada a Objetos (POO) en PHP, uso de herencia, interfaces, excepciones personalizadas, namespaces, autoloading y control de versiones con Git y GitHub.

Proyecto-VideoClub-Pablo-Ismael
## ⚙️ Instalación y configuración
### 1. Clonar el repositorio

git clone https://github.com/vjp-pabloSM/Proyecto_VideoClub_Pablo_Ismael.git

cd proyecto-videoclub

### 2. Inicializar el repositorio en local

git init
git add .
git commit -m "Inicializando proyecto Videoclub"

### 3. Conectar con GitHub

git remote add origin https://github.com/vjp-pabloSM/Proyecto_VideoClub_Pablo_Ismael.git

git push -u origin main

## 🧩 Desarrollo incremental

El proyecto se divide en fases de implementación, cada una añadiendo nuevas funcionalidades.

### 1️⃣ Creación de la clase base Soporte

Contiene los datos básicos de un soporte: título, número y precio.
Incluye una constante estática IVA = 21%.

Métodos:

getPrecio()

getPrecioConIVA()

muestraResumen()

Archivos:
app/Soporte.php
test/inicio.php

### 2️⃣ Herencia: Soportes específicos
Clase	Atributos adicionales	Métodos
CintaVideo	duracion	muestraResumen()
Dvd	idiomas, formatoPantalla	muestraResumen()
Juego	consola, minNumJugadores, maxNumJugadores	muestraJugadoresPosibles(), muestraResumen()
### 3️⃣ Clase Cliente

Gestiona clientes y sus alquileres.

Métodos principales:

tieneAlquilado(Soporte $s)

alquilar(Soporte $s)

devolver(int $numSoporte)

listarAlquileres()

Archivo: test/inicio2.php

### 4️⃣ Clase Videoclub

Administra soportes y clientes.

Atributos:

productos (array)

socios (array)

Métodos:

incluirCintaVideo(), incluirDvd(), incluirJuego()

incluirSocio()

listarProductos()

listarSocios()

alquilaSocioProducto()

devolverSocioProducto()

Archivo: test/inicio3.php

### 5️⃣ Mejoras con abstracción e interfaces

Soporte se convierte en clase abstracta.

Se crea la interfaz Resumible, obligando a implementar muestraResumen().

### 6️⃣ Versionado con etiquetas
Versión	Descripción
v0.329	Versión inicial funcional
v0.331	Namespaces y autoload
v0.337	Excepciones y mejoras
### 7️⃣ Namespaces y autoload

Todas las clases usan:
namespace PROYECTO_VIDEOCLUB_PABLO_ISMAEL;

Se usa spl_autoload_register.

Ejemplo:
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Videoclub;
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Dvd;

### 8️⃣ Excepciones personalizadas

En PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Util:

VideoclubException

SoporteYaAlquiladoException

CupoSuperadoException

SoporteNoEncontradoException

ClienteNoEncontradoException

## 🧪 Ejecución de pruebas

php test/inicio.php
php test/inicio2.php
php test/inicio3.php

## 🧠 Conceptos aplicados

Programación orientada a objetos

Herencia y polimorfismo

Clases abstractas e interfaces

Namespaces

Encadenamiento de métodos

Excepciones personalizadas

Autoloading

Versionado con Git

Logging con Monolog

Composer y gestión de dependencias

PSR-3 (LoggerInterface)

# 🚀 Proyecto Videoclub 3.0

Nueva fase del proyecto donde se añade un sistema de autenticación, gestión de sesión y paneles diferenciados para administrador y clientes.

## 🔐 1. Sistema de login

index.php contiene un formulario con login/password.
Los datos se comprueban en login.php.

Usuarios válidos:

admin / admin

usuario / usuario

✔️ Si el usuario es correcto:

En main.php:

Saludo con su nombre

Enlace “Cerrar sesión”

❌ Si el usuario es incorrecto:

Recargar el formulario

Mostrar aviso de error

## 🛠️ 2. Carga de datos del videoclub (solo administrador)

Si el usuario es admin, se carga en $_SESSION:

Array de soportes

Array de clientes

(Copiados directamente, no mediante include)

## 🖥️ 3. Panel de administración: mainAdmin.php

Debe mostrar:

Mensaje de bienvenida

Listado de clientes

Listado de soportes

## 👤 4. Cambios en la clase Cliente

Se añaden atributos:

user

password

Nuevo método:

getAlquileres(): array

## 👥 5. Panel de cliente: mainCliente.php

Si el login corresponde a un cliente:

Mostrar sus alquileres mediante getAlquileres()

## ➕ 6. Alta de clientes

Formulario: formCreateCliente.php
Procesamiento: createCliente.php

Inserta el nuevo cliente en sesión

Regresa a mainAdmin.php

Si hay errores → vuelve al formulario

## ✏️ 7. Modificación de clientes

Formulario: formUpdateCliente.php
Procesamiento: updateCliente.php

Se puede modificar:

Desde la página del cliente

Desde el panel de administración

## 🗑️ 8. Eliminación de clientes

En el panel de administración:

Botón de borrar

Confirmación mediante JavaScript

Servidor: removeCliente.php

Elimina el cliente de la sesión

Regresa al listado de clientes

# 🧾 Proyecto Videoclub IV (Composer y Logging)

En esta fase del proyecto se profesionaliza la aplicación incorporando herramientas estándar del ecosistema PHP como Composer, Monolog y PSR-3, mejorando la mantenibilidad y la trazabilidad del sistema.

## 📦 Uso de Composer

Se inicializa Composer en el proyecto para gestionar dependencias externas y el autoload de clases.

Dependencias añadidas:
- **monolog/monolog**: sistema de logging
- **phpunit/phpunit** (en require-dev): preparado para futuras pruebas unitarias

El autoload se configura mediante **PSR-4**, eliminando por completo los `include` y `include_once` manuales.

## 🪵 Sistema de logging con Monolog

Se integra Monolog para registrar eventos relevantes del sistema en el archivo: logs/videoclub.log

Características del logging:
- Canal único: `VideoclubLogger`
- Nivel: `DEBUG`
- Registro de mensajes `INFO` y `WARNING`
- Uso de contexto (segundo parámetro) siguiendo el estándar **PSR-3**

### 📌 Logging en Cliente

La clase `Cliente` incorpora un logger que:
- Registra con nivel **INFO** los alquileres y devoluciones correctas
- Registra con nivel **WARNING** los errores antes de lanzar excepciones
- Sustituye los `echo` informativos por llamadas al log
- Mantiene `muestraResumen()` usando `echo`, según el enunciado

### 📌 Logging en Videoclub

La clase `Videoclub` también incorpora logging para:
- Altas de socios y productos
- Alquileres y devoluciones individuales y múltiples
- Errores de negocio (cliente o soporte no encontrado, alquiler no permitido, etc.)

## 🏭 Factoría de Logger (LogFactory)

Para evitar duplicación de código, se crea la clase: Dwes\ProyectoVideoclub\Util\LogFactory

Esta factoría:
- Centraliza la creación y configuración del logger
- Devuelve un objeto que implementa **LoggerInterface (PSR-3)**
- Permite desacoplar las clases del uso directo de Monolog

Tanto `Cliente` como `Videoclub` obtienen el logger desde esta factoría, mejorando el diseño y siguiendo buenas prácticas.

## 🏷️ Versionado

Se crean las siguientes etiquetas en GitHub:
- **v0.511**: integración de Monolog en Cliente y Videoclub
- **v0.515**: refactorización con LogFactory y LoggerInterface

### 👥 Autores

Ismael Gil Jiménez y Pablo Serrano Martín

### 🪪 Licencia

Proyecto educativo sin fines comerciales.
README generado con ayuda de inteligencia artificial (IA).