# Wikiprecios
Aplicación desarrollada en la materia de Desarrollo de Software en la UNPSJB.

## Preparación
Requisitos previos:

Instalar Node.js y NPM:
* `sudo apt-get install -g npm`
* `sudo apt-get install node`

Instalar Bower:
* `sudo npm install -g bower`

Instalar Grunt:
* `sudo npm install -g grunt-cli`

Tener instalado XAMPP o LAMPP:
* `ver la configuracion de la base de datos en application/config/database.php`.

## Despliegue

1. Clonar el repositorio: `https://github.com/emanuelbalcazar/search-and-classification-engine.git`.
2. Colocar el proyecto en la carpeta `htdocs` del xampp o lampp.
3. Ejecutar en el directorio raiz del proyecto `npm install` y `bower install` (puede utilizar grunt, ver mas abajo).
4. Ejecutar `grunt devel` o `grunt prod` (ver la descripción mas abajo).
5. Migrar las tablas entrando en su navegador a: `http://localhost/wikiprecios/migrate`.
6. Migrar los datos entrando en su navegador a : `http://localhost/wikiprecios/seeds`.
7. Acceder a la aplicacion web en `http://localhost/wikiprecios/`.


## Nota

Ver que el archivo `Gruntfile.js` en la raiz del proyecto incluye las siguientes tareas:

* `grunt install` - ejecuta npm install y bower install en secuencia.
* `grunt test` - ejecuta jshint revisando la calidad del codigo fuente solo en los archivos angularjs.
* `grunt devel` - realiza el copiado de fuentes y concatena los archivos js y css del front-end, pero no los minifica (facilitando debbuguear).
* `grunt prod` - realiza el copiado de fuentes, concatena los archivos js y css del front-end y realiza el minificado de los js y css.
