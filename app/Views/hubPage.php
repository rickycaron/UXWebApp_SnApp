<div id="observationCardsContainer">
<?php foreach ($observations as $ob): ?>
        <input type = "hidden" name="obID" id = "obID" value = "<?=$ob->id?>">
        <input type = "hidden" name="username" id = "username" value = "<?=$ob->username?>">
        <div class="card my-2 shadow-sm" style="width:100%;max-width:600px">

            <a href="/html/anobservation/<?=$ob->id?>">
            <div style="position: relative;">
                <img class="card-img" id="observationCardPicture" src="<?php echo data_uri($ob->imageData,$ob->imageType); ?>">
                <div class="card-img" style="box-shadow: inset 0px -50px 40px -20px black;position: absolute; width: 100%; height: 100%;top: 0; left: 0;"></div>
                <h4 class="text-white" style="position: absolute; bottom: 0px; right: 12px;"><?=$ob->username?></h4>
                <span class="material-icons text-white" style="font-size:30px;position: absolute; bottom: 6px; left: 8px" >favorite_border</span>
            </div>
            </a>

            <div class="card-body pt-2 pb-0">
                <div class=" d-flex flex-row py-1">
                    <div class="mr-auto">
                        <h3 class="mb-0"><?=$ob->specieName?></h3>
                    </div>
                    <span class="material-icons my-auto" style="font-size: 40px">expand_less</span>
                </div>
                <hr class="mt-0 mb-2">

                <!--<form action="hub" method="post">
                    <input type = "hidden" name="obID" id = "obID" value = "<?/*=$ob->id*/?>">
                    <input type="submit" name="commentShow" value="showComments" />
                </form>-->
                <?php foreach ($options['comments'] as $co): ?>
                    <div class="py-2">
                       <h5 class="font-weight-bold d-inline"><?=$co->username?>: </h5>
                       <h5 class="d-inline"><?=$co->message?></h5>
                    </div>
                <?php endforeach; ?>


                <div class="d-flex flex-row my-3">
                    <form action="hub" method="post" id = "commentSend">
                    <input type = "hidden" name="obID" id = "obID" value = "<?=$ob->id?>">
                    <input class="form-control" name="message" id = "message" value="<?= set_value('message')?>" placeholder="Create new comment">
                    <!--<span type="submit" class="material-icons my-auto ml-3 mr-2 text-primary" id = "sendComment" style="font-size:30px" onclick="sendComment()" >send</span>-->
                        <input type="submit" name="submitCommit" value="submit" />
                    </form>
                </div>
                <div class="my-2">
                    <h6><?=$ob->date?> at <?=$ob->time?></h6>
                </div>
            </div>

            <div id="dateObject" hidden><?=$ob->date?></div>

        </div>

    <script type="text/javascript">
        var php_lastDate = "<?php echo $ob->date; ?>";
        var php_lastTime = "<?php echo $ob->time; ?>";
    </script>

<?php endforeach; ?>
</div>

<div id="placeholderLoading"></div>

<?php
function data_uri($file, $mime)
{
    $base64   = base64_encode($file);
    return ('data:' . $mime . ';base64,' . $base64);
}
?>
