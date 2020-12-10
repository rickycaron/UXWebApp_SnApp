<style>
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0;
        background-color: #E5F4F1;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #006650;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>
<?php if($userID == session()->get('id')):?>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class=" material-icons" onclick="closeNav()">navigate_next</a>
        <hr class="mt-2 mb-3 my-3"/>
        <a href="<?= base_url()?>/friendList"><?php echo lang('app.Friends') ?></a>
        <hr class="mt-2 mb-3 my-3"/>
        <a href="<?= base_url()?>/account/<?= session()->get('id')?>"><?php echo lang('app.Change_password') ?></a>
        <hr class="mt-2 mb-3 my-3"/>
        <a href="<?= base_url()?>/edit_profile"><?php echo lang('app.Edit_profile') ?></a>
        <hr class="mt-2 mb-3 my-3"/>
        <?php if($userID == session()->get('id')):?>
            <a href="<?= base_url()?>/logout"><?php echo lang('app.Logout') ?></a>
        <?php endif?>
        <hr class="mt-2 mb-3 my-3"/>
    </div>
<?php endif?>

<input type="hidden" id="hidden_userID" value="<?=$userID ?>"/>
<div class="d-flex flex-row m-3" style="width:100%;max-width:600px">

    <div class="">
        <img src="<?php echo data_uri($image[0]->imagedata, $image[0]->imagetype); ?>" class="rounded-circle" alt="templatemo easy profile" style="width: 100px;">
    </div>
    <div class="mx-4 w-100">
        <div class="row justify-content-between">
            <h2 class="user_name"><?= $username?> </h2>
            <a><span onclick="openNav()" class="material-icons " style="font-size:50px;" id="header_icon_2">more_horiz</span></a>
            <script>
                function openNav() {
                    document.getElementById("mySidenav").style.width = "250px";
                }

                function closeNav() {
                    document.getElementById("mySidenav").style.width = "0";
                }
            </script>

        </div>
        <div class="row">
            <h4 class="personal_description"><?=$description[0]->description?></h4>
        </div>
    </div>

</div>



<div class="d-flex flex-row my-3">
    <div class="d-flex flex-column align-items-center mx-2">
        <span class = "h6" > observations</span>
        <span class = "h6" > <?=$observationCount[0]->observationCount?></span>
    </div>
    <div class="d-flex flex-column align-items-center mx-2">
        <span class = "h6" > likes</span>
        <span class = "h6" > <?=$likeCount[0]->likeCount?></span>
    </div>
    <div class="d-flex flex-column align-items-center mx-2">
        <span class = "h6" > comments</span>
        <span class = "h6" > <?=$commentCount[0]->commentCount?></span>
    </div>
    <div class="d-flex flex-column align-items-center mx-2">
        <span class = "h6" > friends</span>
        <span class = "h6" > <?=$friendCount[0]->friendCount?></span>
    </div>
    <div class="d-flex flex-column align-items-center mx-2">
        <span class = "h6" > points</span>
        <span class = "h6" > <?=$pointCount[0]->pointCount?></span>
    </div>
</div>

<?php if($userID != session()->get('id')):?>
    <?php switch ($requestStatus):
        case 0: ?>
            <button class="d-flex flex-row btn btn-lg btn-third btn-block my-3" style="width:100%;max-width:600px">
                <span class="material-icons">person_add_alt_1</span>
                <p>request sended</p>
            </button>
        <?php break; ?>
        <?php case 1: ?>
            <button class="d-flex flex-row btn btn-lg btn-third btn-block my-3" style="width:100%;max-width:600px">
                <span class="material-icons">person_add_alt_1</span>
                <p>friend</p>
            </button>
        <?php break; ?>
        <?php case 2: ?>
            <button id="send_friend_request" class="d-flex flex-row btn btn-lg btn-primary btn-block my-3" style="width:100%;max-width:600px">
                <span class="material-icons">person_add_alt_1</span>
                <p>add friend</p>
            </button>
        <?php break; ?>
        <?php case 3: ?>
            <button id="send_friend_request" class="send_friend_request d-flex flex-row btn btn-lg btn-primary btn-block my-3" style="width:100%;max-width:600px">
                <span class="material-icons">person_add_alt_1</span>
                <p>add friend</p>
            </button>
            <?php break; ?>
    <?php endswitch; ?>
<?php endif?>

<div id="observationCardsContainer">
<?php foreach ($observations as $ob): ?>

    <div class="card my-2 shadow-sm" style="width:100%;max-width:600px">
<div class="card my-2 shadow-sm" style="width:100%;max-width:600px">

        <a href="/html/anobservation/<?=$ob->id?>">
            <div style="position: relative;">
                <img class="card-img" id="observationCardPicture" src="<?php echo data_uri($ob->imageData,$ob->imageType); ?>">
                <div class="card-img" style="box-shadow: inset 0px -50px 40px -20px black;position: absolute; width: 100%; height: 100%;top: 0; left: 0;"></div>
                <h4 class="text-white" style="position: absolute; bottom: 0px; right: 12px;"><?=$ob->username?></h4>
                <span class="material-icons text-white" style="font-size:30px;position: absolute; bottom: 6px; left: 8px">favorite_border</span>
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
<!--            <div class="py-2">-->
<!--                <h5 class="font-weight-bold d-inline">Joppe Leers: </h5>-->
<!--                <h5 class="d-inline">Wow what a nice flower!</h5>-->
<!--            </div>-->
            <div class="d-flex flex-row my-3">
                <input type="txt" class="form-control" name="comment" placeholder="Create new comment">
                <span class="material-icons my-auto ml-3 mr-2 text-primary" style="font-size:30px">send</span>
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
<div id="upToDateDiv" hidden></div>
<div id="endOfObservations"></div>
<div id="placeholderLoading"></div>

<?php
function data_uri($file, $mime)
{
    $base64   = base64_encode($file);
    return ('data:' . $mime . ';base64,' . $base64);
}
?>
