<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>          
        <title>ALTO Viewer - <?php echo $image; ?> - <?php echo $vScale; ?> x <?php echo $hScale; ?> - (<?php echo $imageSize[0]; ?>x<?php echo $imageSize[1]; ?>px)</title>
    </head>
    <body>
        <div class="menu">
            <div class="menuBox" id="toggleBox">
                <span>Toggle Layers</span><br />
                <button id="strings" >Strings</button><br />
                <button id="lines" >TextLine</button><br />
                <button id="blocks" >TextBlock</button><br />
                <button id="printspace" >PrintSpace</button><br />
            </div>
        </div>

        <div id="image">
            <img 
                src="<?php print 'images/' . $this->imageName . '.jpg' ?>" 
                width="<?php echo $this->scaledWidth; ?>" 
                height="<?php echo $this->scaledHeight; ?>" />
                <?php foreach ($this->strings as $string) { ?>
              <div class="highlighter" id="highlight-string" 
                   style=" left: <?php echo $string->getHPos(); ?>px; 
                   top: <?php echo $string->getVPos(); ?>px; 
                   width: <?php echo $string->getWidth(); ?>px; 
                   height: <?php echo $string->getHeight(); ?>px;
                   display: none;
                   filter: alpha(opacity=20)" >
              </div>
            <?php } ?>
            <script>
              $("button[id*=strings]").click(function () {
                  $("div[id*=highlight-string]").toggle();
              });
            </script>

            <?php foreach ($this->textLines as $textLine) { ?>
              <div class="highlighter" id="highlight-line" 
                   style=" left: <?php echo $textLine->getHPos(); ?>px; 
                   top: <?php echo $textLine->getVPos(); ?>px; 
                   width: <?php echo $textLine->getWidth(); ?>px; 
                   height: <?php echo $textLine->getHeight(); ?>px; 
                   display: none;
                   filter: alpha(opacity=50)" >
              </div>
            <?php } ?>
            <script>
              $("button[id*=lines]").click(function () {
                  $("div[id*=highlight-line]").toggle();
              });
            </script>

            <?php foreach ($this->textBlocks as $textBlock) { ?>
              <div class="highlighter" id="highlight-block" 
                   style=" left: <?php echo $textBlock->getHPos(); ?>px; 
                   top: <?php echo $textBlock->getVPos(); ?>px; 
                   width: <?php echo $textBlock->getWidth(); ?>px; 
                   height: <?php echo $textBlock->getHeight(); ?>px; 
                   display: none;
                   filter: alpha(opacity=50)" >
              </div>
            <?php } ?>
            <script>
              $("button[id*=blocks]").click(function () {
                  $("div[id*=highlight-block]").toggle();
              });
            </script>

            <div class="highlighter" id="highlight-printspace" 
                 style=" left: <?php echo $this->printSpace->getHPos(); ?>px; 
                 top: <?php echo $this->printSpace->getVPos(); ?>px; 
                 width: <?php echo $this->printSpace->getWidth(); ?>px; 
                 height: <?php echo $this->printSpace->getHeight(); ?>px; 
                 display: none;
                 filter: alpha(opacity=20)" >
            </div>
            <script>
              $("button[id*=printspace]").click(function () {
                  $("div[id*=highlight-printspace]").toggle();
              });
            </script>


        </div>
    </body>
</html>
