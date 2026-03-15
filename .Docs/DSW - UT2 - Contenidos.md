# Introducción a PHP

<!-- TOC tocDepth:2..3 chapterDepth:2..6 -->

- [1. **1\. ¿Qué es PHP?**](#1-1-¿qué-es-php)
- [2. **2\. Mecanismo de generación de páginas web con código embebido**](#2-2-mecanismo-de-generación-de-páginas-web-con-código-embebido)
- [3. **3\. Etiquetas de apertura y cierre en PHP**](#3-3-etiquetas-de-apertura-y-cierre-en-php)
- [4. **4\. Sintaxis básica del lenguaje**](#4-4-sintaxis-básica-del-lenguaje)
    - [4.1. **Comentarios**](#41-comentarios)
    - [4.2. **Instrucciones**](#42-instrucciones)
- [5. **5\. Mostrar contenido:**](#5-5-mostrar-contenido)
- [6. **echo y print**](#6-echo-y-print)
- [7. **6\. Variables en PHP**](#7-6-variables-en-php)
    - [7.1. **Declaración y uso**](#71-declaración-y-uso)
    - [7.2. **Tipos más comunes**](#72-tipos-más-comunes)
    - [7.3. **Ámbito de las variables**](#73-ámbito-de-las-variables)
- [8. **7\. Operadores básicos**](#8-7-operadores-básicos)
    - [8.1. **Aritméticos**](#81-aritméticos)
    - [8.2. **Asignación**](#82-asignación)
    - [8.3. **Comparación**](#83-comparación)
    - [8.4. **Lógicos**](#84-lógicos)
- [9. **8\. Directivas de configuración (ini_set, error_reporting)**](#9-8-directivas-de-configuración-ini_set-error_reporting)
- [10. **9\. Probando sentencias simples**](#10-9-probando-sentencias-simples)
- [11. **10\. Buenas prácticas iniciales**](#11-10-buenas-prácticas-iniciales)
- [12. **1\. ¿Qué es un formulario en HTML?**](#12-1-¿qué-es-un-formulario-en-html)
- [13. **2\. Métodos de envío: GET y POST**](#13-2-métodos-de-envío-get-y-post)
    - [13.1. **Método GET**](#131-método-get)
    - [13.2. **Método POST**](#132-método-post)
    - [13.3. **Diferencias resumidas**](#133-diferencias-resumidas)
- [14. **3\. Cómo recibir datos en PHP**](#14-3-cómo-recibir-datos-en-php)
    - [14.1. **A) Con $\_GET**](#141-a-con-_get)
    - [14.2. **B) Con $\_POST**](#142-b-con-_post)
    - [14.3. **C) Con $\_REQUEST**](#143-c-con-_request)
    - [14.4. **Ejemplo seguro usando isset()**](#144-ejemplo-seguro-usando-isset)
- [15. **4\. Arrays en PHP**](#15-4-arrays-en-php)
    - [15.1. **A) Array indexado**](#151-a-array-indexado)
    - [15.2. **B) Array asociativo**](#152-b-array-asociativo)
    - [15.3. **C) Superglobales como arrays asociativos**](#153-c-superglobales-como-arrays-asociativos)
- [16. **5\. Ejemplo completo: formulario con método POST**](#16-5-ejemplo-completo-formulario-con-método-post)
    - [16.1. **HTML (formulario.html)**](#161-html-formulariohtml)
    - [16.2. **PHP (procesar.php)**](#162-php-procesarphp)
- [17. **6\. Validación básica en el cliente y el servidor**](#17-6-validación-básica-en-el-cliente-y-el-servidor)
- [18. **7\. Ámbitos de las variables**](#18-7-ámbitos-de-las-variables)
    - [18.1. **A) Global**](#181-a-global)
    - [18.2. **B) Local**](#182-b-local)
    - [18.3. **C) Superglobales (siempre disponibles)**](#183-c-superglobales-siempre-disponibles)
- [19. **8\. Formularios con arrays**](#19-8-formularios-con-arrays)
- [20. **9\. Buenas prácticas**](#20-9-buenas-prácticas)
- [21. **Recursos**](#21-recursos)
- [22. **Contenidos**](#22-contenidos)
- [23. **Instalación**](#23-instalación)
    - [23.1. **Configuración**](#231-configuración)
    - [23.2. **Primeros pasos**](#232-primeros-pasos)
    - [23.3. **Ramas**](#233-ramas)
    - [23.4. **Cómo eliminar los cambios realizados en el repositorio que aún no se han incorporado a él**](#234-cómo-eliminar-los-cambios-realizados-en-el-repositorio-que-aún-no-se-han-incorporado-a-él)
    - [23.5. **Comandos avanzados**](#235-comandos-avanzados)
- [24. **Recursos**](#24-recursos)
- [25. **Contenidos**](#25-contenidos)
    - [25.1. **Aspectos básicos**](#251-aspectos-básicos)
    - [25.2. **Creación y sincronización de repositorios**](#252-creación-y-sincronización-de-repositorios)
    - [25.3. **Forks**](#253-forks)
    - [25.4. **Issues**](#254-issues)
    - [25.5. **Pull requests**](#255-pull-requests)

<!-- /TOC -->

# **UT2 – Introducción al desarrollo en servidor con PHP**

## 1. **1\. ¿Qué es PHP?**

**PHP** (acrónimo recursivo de _PHP: Hypertext Preprocessor_) es un lenguaje de programación del lado del servidor, ampliamente utilizado para desarrollar aplicaciones web dinámicas.

- Fue creado en 1994 por Rasmus Lerdorf.

- Su código se **integra en documentos HTML** y se **ejecuta en el servidor**, generando como salida HTML plano que se envía al navegador del cliente.

- Es **gratuito**, de **código abierto** y compatible con casi todos los servidores (Apache, Nginx…) y sistemas operativos.

---

## 2. **2\. Mecanismo de generación de páginas web con código embebido**

Una página web escrita con PHP suele contener **HTML con fragmentos de código PHP incrustado**.

📌 El servidor procesa el archivo PHP, **ejecuta el código PHP** y **devuelve el resultado HTML** al navegador.

**Ejemplo básico:**

```
<!DOCTYPE html>
<html>
<head>
  <title>Ejemplo PHP</title>
</head>
<body>
  <h1>Bienvenido</h1>
  <p>La hora actual es: <?php echo date("H:i:s"); ?></p>
</body>
</html>
```

El navegador solo verá el resultado (ej. “La hora actual es: 14:38:01”), **nunca el código PHP original**.

---

## 3. **3\. Etiquetas de apertura y cierre en PHP**

PHP se puede incrustar en HTML usando estas etiquetas:

```
<?php
   // Código PHP aquí
?>
```

Otras formas menos recomendadas:

```
<?
   // Corto, pero no siempre habilitado
?>

<script language="php">
   // En desuso
</script>
```

## ⚠️ Siempre usa \<?php ?\> por compatibilidad y claridad.

## 4. **4\. Sintaxis básica del lenguaje**

### 4.1. **Comentarios**

```
// Comentario de una línea
# También válido para una línea
/*
Comentario
de varias líneas
*/
```

### 4.2. **Instrucciones**

Cada instrucción termina en punto y coma (;):

```
echo "Hola mundo";
```

---

## 5. **5\. Mostrar contenido:**

## 6. **echo y print**

```
echo "Hola mundo";      // Más común, permite múltiples parámetros
print "Hola mundo";     // Similar, pero menos flexible
```

También se puede usar dentro de HTML:

```
<p><?php echo "Este texto se genera con PHP"; ?></p>
```

---

## 7. **6\. Variables en PHP**

### 7.1. **Declaración y uso**

Las variables en PHP comienzan con el signo $:

```
$nombre = "Sergio";
$edad = 25;
```

### 7.2. **Tipos más comunes**

- Cadenas (string): "Hola"

- Enteros (int): 25

- Decimales (float): 3.14

- Booleanos (bool): true o false

📌 No es necesario declarar el tipo: PHP es un lenguaje de **tipado dinámico**.

---

### 7.3. **Ámbito de las variables**

- **Local**: dentro de una función.

- **Global**: accesible en todo el script (fuera de funciones).

- **Superglobales**: variables especiales como $\_GET, $\_POST, $\_SERVER, etc.

Ejemplo de variable global:

```
$mensaje = "Hola";

function saludar() {
  global $mensaje;
  echo $mensaje;
}
```

---

## 8. **7\. Operadores básicos**

### 8.1. **Aritméticos**

```
+  // Suma
-  // Resta
*  // Multiplicación
/  // División
%  // Módulo (resto)
```

### 8.2. **Asignación**

```
$x = 5;
$x += 2; // equivale a $x = $x + 2;
```

### 8.3. **Comparación**

```
==   // Igual
!=   // Distinto
<    // Menor que
>    // Mayor que
<=   // Menor o igual
>=   // Mayor o igual
===  // Igual en valor y tipo
```

### 8.4. **Lógicos**

```
&&   // Y
||   // O
!    // Negación
```

---

## 9. **8\. Directivas de configuración (ini_set, error_reporting)**

Las **directivas** permiten modificar el comportamiento de PHP:

```
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

Esto activa la visualización de errores en pantalla, útil en desarrollo.

## 🔒 En producción, se recomienda **desactivar los errores visibles** por seguridad.

## 10. **9\. Probando sentencias simples**

Veamos algunos ejemplos breves de scripts que el alumnado puede ejecutar en su entorno local (XAMPP, Laragon…):

```
<?php
echo "Hola, mundo";   // Muestra texto

$precio = 10.5;
$cantidad = 3;
$total = $precio * $cantidad;

echo "<p>Total: $total €</p>";
?>
```

---

## 11. **10\. Buenas prácticas iniciales**

- Guardar los archivos con extensión **.php**

- Colocar el código en la carpeta adecuada del servidor local (ej. htdocs en XAMPP)

- Comprobar que el **servidor Apache está activo**

- Evitar el uso de código PHP sin etiquetas

- Activar los errores en desarrollo

# Manejo de formularios

# Manejo de formularios

# **Interacción con el usuario mediante formularios en PHP**

---

## 12. **1\. ¿Qué es un formulario en HTML?**

Un **formulario** es una sección de una página web que permite al usuario introducir datos y enviarlos al servidor para ser procesados.

```
<form action="procesar.php" method="post">
  <label>Nombre:</label>
  <input type="text" name="nombre">
  <input type="submit" value="Enviar">
</form>
```

- **action**: indica el archivo PHP que procesará los datos.

- **method**: indica el método de envío (GET o POST).

---

## 13. **2\. Métodos de envío: GET y POST**

### 13.1. **Método GET**

- Envía los datos **en la URL**.
- Se puede ver en la barra de direcciones:  
   procesar.php?nombre=Sergio
- Ideal para:
    - Formularios simples
    - Búsquedas
    - Enlaces compartibles

### 13.2. **Método POST**

- Envía los datos de forma **oculta** en el cuerpo de la petición.
- No se ven en la URL.
- Ideal para:
    - Formularios de login
    - Registro de usuarios
    - Envío de datos sensibles

### 13.3. **Diferencias resumidas**

| Característica  | GET                | POST                      |
| --------------- | ------------------ | ------------------------- |
| Datos en la URL | Sí                 | No                        |
| Seguridad       | Baja               | Alta (relativa)           |
| Longitud        | Limitada           | Ilimitada (prácticamente) |
| Visibilidad     | Pública            | Oculta                    |
| Uso común       | Búsquedas, filtros | Formularios de login      |

---

## 14. **3\. Cómo recibir datos en PHP**

### 14.1. **A) Con $\_GET**

```
$nombre = $_GET["nombre"];
echo "Hola, $nombre";
```

### 14.2. **B) Con $\_POST**

```
$nombre = $_POST["nombre"];
echo "Hola, $nombre";
```

### 14.3. **C) Con $\_REQUEST**

```
$nombre = $_REQUEST["nombre"];
// Puede venir de GET o POST (menos recomendado por seguridad)
```

## ⚠️ Es importante verificar siempre que los datos existen antes de usarlos.

### 14.4. **Ejemplo seguro usando isset()**

```
if (isset($_POST['nombre'])) {
  $nombre = $_POST['nombre'];
  echo "Hola, $nombre";
} else {
  echo "No se ha recibido el nombre.";
}
```

---

## 15. **4\. Arrays en PHP**

Los arrays permiten almacenar múltiples valores en una sola variable.

### 15.1. **A) Array indexado**

```
$colores = ["rojo", "verde", "azul"];
echo $colores[1];  // Imprime 'verde'
```

### 15.2. **B) Array asociativo**

```
$persona = [
  "nombre" => "Sergio",
  "edad" => 25
];
echo $persona["nombre"];
```

### 15.3. **C) Superglobales como arrays asociativos**

$\_POST y $\_GET son arrays asociativos donde las claves corresponden al atributo name del formulario.

---

## 16. **5\. Ejemplo completo: formulario con método POST**

### 16.1. **HTML (formulario.html)**

```
<form action="procesar.php" method="post">
  <label>Nombre:</label>
  <input type="text" name="nombre" required>
  <label>Edad:</label>
  <input type="number" name="edad" required>
  <input type="submit" value="Enviar">
</form>
```

### 16.2. **PHP (procesar.php)**

```
<?php
if (isset($_POST['nombre']) && isset($_POST['edad'])) {
  $nombre = $_POST['nombre'];
  $edad = $_POST['edad'];

  echo "<h1>Hola, $nombre</h1>";
  echo "<p>Tienes $edad años.</p>";
} else {
  echo "Faltan datos.";
}
?>
```

---

## 17. **6\. Validación básica en el cliente y el servidor**

- **HTML5** permite validaciones rápidas (atributo required, type="email", etc.)

- Pero **siempre hay que validar en el servidor** también, por seguridad.

Ejemplo de validación en PHP:

```
if (!is_numeric($_POST['edad'])) {
  echo "La edad debe ser un número.";
}
```

---

## 18. **7\. Ámbitos de las variables**

En PHP, el **ámbito** determina dónde se puede acceder a una variable.

### 18.1. **A) Global**

```
$nombre = "Sergio"; // fuera de funciones

function saludar() {
  global $nombre; // accede a la variable global
  echo "Hola, $nombre";
}
```

### 18.2. **B) Local**

```
function prueba() {
  $mensaje = "Hola"; // solo accesible dentro de esta función
}
```

### 18.3. **C) Superglobales (siempre disponibles)**

- $\_GET

- $\_POST

- $\_SERVER

- $\_SESSION, etc.

Estas **no necesitan ser declaradas** globalmente.

---

## 19. **8\. Formularios con arrays**

Puedes usar nombres como name="intereses\[\]" para recoger varios datos en un array.

```
<input type="checkbox" name="intereses[]" value="Deporte">
<input type="checkbox" name="intereses[]" value="Música">
<input type="checkbox" name="intereses[]" value="Viajar">
```

En PHP:

```
foreach ($_POST['intereses'] as $interes) {
  echo "<p>Te gusta: $interes</p>";
}
```

---

## 20. **9\. Buenas prácticas**

✅ Siempre validar y sanitizar los datos recibidos.

✅ Usar isset() para comprobar si una variable existe.

✅ Evitar confiar solo en validaciones del lado del cliente.

✅ Comentar el código si se hace complejo.

✅ Usar indentación clara.

# ANEXO: Introducción a Git

# Introducción a Git

El software de control de versiones diseñado por Linus Torvalds más usado en la actualidad.

## 21. **Recursos**

- [Web oficial](https://git-scm.com/)
- [Referencia oficial](https://git-scm.com/docs)
- [Libro oficial](https://git-scm.com/book/es/v2) (en español)
- [Cheat Sheet](https://training.github.com/downloads/es_ES/github-git-cheat-sheet/)
- [Tutorial de Git de W3Schools](https://www.w3schools.com/git/)

## 22. **Contenidos**

## 23. **Instalación**

[Proceso de instalación en diferentes plataformas](https://git-scm.com/book/es/v2/Inicio---Sobre-el-Control-de-Versiones-Instalaci%C3%B3n-de-Git)

- De entre las opciones que se sugieren para instalar Git en Windows, optaremos por realizar la instalación desde la web oficial de Git.

### 23.1. **Configuración**

- git config \[ [referencia](https://git-scm.com/docs/git-config) | [ejemplo](https://git-scm.com/book/es/v2/Inicio---Sobre-el-Control-de-Versiones-Configurando-Git-por-primera-vez) \]
    - \--global user.name
    - \--global user.email
    - \--list
- Fichero ".gitconfig" \[ [ejemplo](https://git-scm.com/book/es/v2/Inicio---Sobre-el-Control-de-Versiones-Configurando-Git-por-primera-vez#_comprobando_tu_configuraci%C3%B3n) \]
- git init \[ [referencia](https://git-scm.com/docs/git-init) | [ejemplo](https://git-scm.com/book/es/v2/Fundamentos-de-Git-Obteniendo-un-repositorio-Git) \]
- Subdirectorio ".git" \[ [ejemplo](https://git-scm.com/book/es/v2/Fundamentos-de-Git-Obteniendo-un-repositorio-Git) \]

### 23.2. **Primeros pasos**

- git status \[ [referencia](https://git-scm.com/docs/git-status) | [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
    - \-s \[ [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
- git branch \-m \[ [referencia](https://git-scm.com/docs/git-branch#Documentation/git-branch.txt--m)\]
- git add \[ [referencia](https://git-scm.com/docs/git-add) | [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
    - \--all: Añade al área de stage todos los cambios (ficheros nuevos, modificados y eliminados). Es equivalente a \-a
- git commit \[ [referencia](https://git-scm.com/docs/git-commit) | [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
    - \-m \[ [referencia](https://git-scm.com/docs/git-commit#Documentation/git-commit.txt--mltmsggt) \]
    - \-a: automáticamente añade al área de stage todos los cambios que afecten a tracked files.
- git log \[ [referencia](https://git-scm.com/docs/git-log) | [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Viewing-the-Commit-History) \]
    - \--graph: muestra de forma visual las diferentes ramas.
    - \--all: visualiza todos los commits, incluyendo los commits futuros.
    - \--oneline: muestra cada commit en una única línea.
- git diff \[ [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
- git rm \--cached \[ [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]
- Aliases \[ [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Git-Aliases) \]
- git checkout

\<fichero\> \[ [referencia](https://git-scm.com/docs/git-checkout) \]

- Deshace los últimos cambios del fichero indicado y lo deja en la versión del último commit.

\<ID\>

- Nos permite movernos a un commit determinado.
- Fichero ".gitignore" \[ [ejemplo](https://git-scm.com/book/en/v2/Git-Basics-Recording-Changes-to-the-Repository) \]

### 23.3. **Ramas**

- git branch \[ [ejemplo](https://git-scm.com/book/es/v2/Ramificaciones-en-Git-%C2%BFQu%C3%A9-es-una-rama%3F) \]: Crea una nueva rama
- git checkout/switch \[ [ejemplo](https://git-scm.com/book/es/v2/Ramificaciones-en-Git-%C2%BFQu%C3%A9-es-una-rama%3F) \]
    - git checkout \-b \<rama\>: Crea una nueva rama y se cambia a ella en un único comando
- git merge \[ [ejemplo](https://git-scm.com/book/es/v2/Ramificaciones-en-Git-Procedimientos-B%C3%A1sicos-para-Ramificar-y-Fusionar) \]
- git branch \-d: Elimina una rama
- git branch \-v \[ [ejemplo](https://git-scm.com/book/es/v2/Ramificaciones-en-Git-Gesti%C3%B3n-de-Ramas) \]: Muestra las ramas locales
- git branch \-a: Muestra todas las ramas (locales y remotas)
- git log \--oneline \--decorate \--graph \--all: Muestra gráficamente el log, incluyendo los commits posteriores al actual. No muestra el detalle de cada commit. Únicamente su id corto.
- git push \-u origin \<nombrederama\>: Sube la rama \<nombrederama\> desde nuestro repositorio local a GitHub.
- [Traer a nuestro repositorio local una rama creada previamente en GitHub](https://www.w3schools.com/git/git_branch_pull_from_remote.asp?remote=github)

### 23.4. **Cómo eliminar los cambios realizados en el repositorio que aún no se han incorporado a él**

Copiar

```

git reset --hard

git clean -fd

```

### 23.5. **Comandos avanzados**

- git reset
- git checkout
- git reset \--hard
- git reflog
- git tag
- git stash

# ANEXO: Github

# ANEXO: Github

El complemento indispensable de Git

## 24. **Recursos**

- [Web oficial](https://github.com/)
- [Documentación oficial](https://docs.github.com/es)
- [Tutorial de GitHub de W3Schools](https://www.w3schools.com/git/git_remote_getstarted.asp?remote=github)
- Clientes gráficos de GitHub
    - [Cliente oficial de GitHub](https://desktop.github.com/)
    - [GitKraken](https://www.gitkraken.com/)
    - [Sourcetree](https://www.sourcetreeapp.com/)
    - [Fork](https://git-fork.com/)

## 25. **Contenidos**

### 25.1. **Aspectos básicos**

- [Creación de cuenta de usuario](https://docs.github.com/es/get-started/signing-up-for-github/signing-up-for-a-new-github-account)
- [Explorar repositorios](https://github.com/explore)
- [Stars](https://docs.github.com/es/get-started/exploring-projects-on-github/saving-repositories-with-stars)
- [Archivos README](https://docs.github.com/es/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/about-readmes)
- Autenticación mediante SSH
    - [Comprobar las claves existentes](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/checking-for-existing-ssh-keys)
    - [Generar una nueva clave en caso necesario](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent)
    - [Agregar tu clave públic](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account)[Generación de una nueva clave SSH y adición al agente SSH \- Documentación de GitHub](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent)[a a tu cuenta de GitHub](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account)
    - [Probar tu conexión SSH](https://docs.github.com/es/authentication/connecting-to-github-with-ssh/testing-your-ssh-connection)

### 25.2. **Creación y sincronización de repositorios**

- [Creación de repositorio en GitHub](https://docs.github.com/es/repositories/creating-and-managing-repositories/creating-a-new-repository)
- Sincronización con el repositorio local
    - [Clonando en local el repositorio remoto](https://docs.github.com/es/repositories/creating-and-managing-repositories/cloning-a-repository?tool=cli)

Creando un nuevo repositorio mediante línea de comandos y sincronizándolo con el nuevo repositorio de GitHub:  
git init  
git add README.md  
git commit \-m "first commit"  
git branch \-M main  
git remote add origin git@github.com:XXX/YYY.git

- git push \-u origin main

Sincronizando un repositorio existente con el nuevo repositorio de GitHub y subiendo los cambios mediante línea de comandos:  
git remote add origin git@github.com:XXX/YYY.git  
git branch \-M main

- git push \-u origin main
- [Subir cambios a GitHub mediante "git push"](https://docs.github.com/es/repositories/working-with-files/managing-files/adding-a-file-to-a-repository#adding-a-file-to-a-repository-using-the-command-line)
- [Posteriormente, podremos actualizar cambios en local mediante "git pull"](https://docs.github.com/es/get-started/using-git/getting-changes-from-a-remote-repository#pulling-changes-from-a-remote-repository)

### 25.3. **Forks**

Un _fork_ es un **nuevo** repositorio que se crea como copia de otro repositorio original. Se suele utilizar cuando nos gustaría realizar modificaciones de un proyecto en otro totalmente independiente porque no tenemos permisos de modificación en el original o simplemente queremos realizar cambios para posteriormente proponerlos mediante _pull requests_.

### 25.4. **Issues**

Las _issues_ son una herramienta que proporciona GitHub para permitir a los usuarios solicitar la corrección de errores en el código de un repositorio, solicitar nuevas funcionalidades, etc.

### 25.5. **Pull requests**

Las _pull requests_ permiten a los desarrolladores proponer cambios en el código de un repositorio determinado. Un usuario remite el código con los cambios al propietario del repositorio, quien posteriormente se encargará de revisar la propuesta y aceptarla o descartarla.
