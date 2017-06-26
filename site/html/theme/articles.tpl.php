<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>          
        <title>ALTO Articles - <?php echo $image; ?> - <?php echo $vScale; ?> x <?php echo $hScale; ?> - (<?php echo $imageSize[0]; ?>x<?php echo $imageSize[1]; ?>px)</title>
    </head>
    <body>
        <div class="menu">
            <div class="menuBox" id="toggleBox">
                <button id="blocks" >TextBlock</button><br />
            </div>
        </div>

        <div id="image">
            <img
                src="<?php print 'images/mn_19231115_001.jpg' ?>" 
                width="<?php echo $scaledWidth; ?>" 
                height="<?php echo $scaledHeight; ?>" />

            <?php echo $content; ?>
            <script>
              $("button[id*=blocks]").click(function () {
                  $("div[id*=highlight-block]").toggle();
              });
            </script>
        </div>
    </body>
</html>
