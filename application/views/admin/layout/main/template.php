<!DOCTYPE html>
<html>
    <head><?php echo $tags; ?></head>
<body  style="padding-top: 75px">
    <header>
        <?php echo isset($header)? $header : ''; ?>
    </header>
    <section id="content" class="container-fluid">
        <div class="row">
            <div class="col-sm-12 main">
                <?php echo $content; ?>
            </div>
        </div>
    </section>
    <footer>
        <?php echo isset($footer)? $footer : ''; ?>
    </footer>
</body>
</html>