<!doctype html>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Load dynamically and optimized style with PHP</title>
    <meta name="description" content="A smart way to use PHP to load dynamically style">
    <meta name="author" content="Dario Passariello">

    <link rel="stylesheet" href="styles.css?<?php echo time()?>">

  </head>

  <body>

    <main>
      <article>

        <h2>Load dynamically and optimized style with PHP</h2>
        <h4>Compress your style in one file. Dynamically!</h4>

        <img src="assets/minify.jpg" width="380" alt="banner" />

        <p>
        This script permit to you to use /style.css but in<br/>
        reality it's run the PHP script that unify and compress all css in a folder.<br/>
        <br/>
        This example help you to understand how it's works...<br/>
        Long life to the dynamics!
        </p>

      </article>
    </main>

  </body>

</html>

