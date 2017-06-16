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
                src="<?php print 'images/' . $imageName . '.jpg' ?>" 
                width="<?php echo $scaledWidth; ?>" 
                height="<?php echo $scaledHeight; ?>" />

            <?php foreach ($textBlocks as $textBlock) { ?>
              <div class="highlighter" id="highlight-block" 
                   style=" 
                   left:    <?php echo $textBlock->getHPos(); ?>px; 
                   top:     <?php echo $textBlock->getVPos(); ?>px; 
                   width:   <?php echo $textBlock->getWidth(); ?>px; 
                   height:  <?php echo $textBlock->getHeight(); ?>px; 
                   display: none;
                   filter:  alpha(opacity=50)" >
              </div>
            <?php } ?>
            <script>
              $("button[id*=blocks]").click(function () {
                  $("div[id*=highlight-block]").toggle();
              });
            </script>
        </div>
    </body>
</html>
