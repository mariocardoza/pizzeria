# Pizzería

Proyecto desarrollado en Laravel 6

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

Mira **Deployment** para conocer como desplegar el proyecto.


### Pre-requisitos 📋

_Que cosas necesitas para instalar el software y como instalarlas_

```
Da un ejemplo
```

### Instalación 🔧

_Sigue estos ejemplos_

_Descargue el repositorio y copielo en la carpeta de su preferencia_

_Accede a la carpera directorio del proyecto desde un terminal o línea de comandos_

```
C:\Descargas\pizzeria
```

_Despues con un editor de texto copie el contenido del archivo .env.example en un nuevo archivo llamada .env_

```
Dentro del archivo .env diríjase al la linea
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD='secret'

y configure segun su servidor mysql
```

_Luego desde la terminal ejecute el siguiente comando_

```
php artisan migrate
```
_Este comando hara las migraciones para poner utilizar el proyecto_

_Luego siempre desde la terminal ejecute el comando_

```
php artisan db:seed
```
_Si todo fue correcto realizara unos registros con datos de pruebas para poner comenzar a utilizar_

## Para ejecutar el proyecto ⚙️

_Ya para terminar con la cunfiguracion si todo a sido correcto debe se ejecutar siempre desde la terminal el siguiente comado_

```
php artisan serve
```

_Para realizar las pruebas se proporciona un usuario administrador de ejemplo_

```
las credenciales son: 
email: admin@admin.com
contraseña: sysadmin
```

## Construido con 🛠️

_Menciona las herramientas que utilizaste para crear tu proyecto_

* [Laravel](https://laravel.com/) 
* [Vuejs](https://vuejs.org/) 
* [Jquery](https://jquery.com/) 
* [AdminLTE3](https://adminlte.io/themes/dev/AdminLTE/index.html) 

## Autores ✒️



* **Mario Cardoza** - *Programador* - [villanuevand](https://github.com/mariocardoza)

## Licencia 📄

Este proyecto está bajo la Licencia (Tu Licencia) - mira el archivo [LICENSE.md](LICENSE.md) para detalles
