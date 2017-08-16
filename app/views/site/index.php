<?php

/* @var $this yii\web\View */

$this->title = 'IMDJ - Início';
?>
<div class="row">
    <div class="col-md-8">
        <div id="dropZone">
            <div class="row">
                <div class="col-sm-3">
                    <?=\yii\helpers\Html::img('@web/images/up.png')?>
                </div>
                <div class="col-sm-9">
                    <h2>Arraste e solte seu arquivo de música aqui.</h2>
                    <p>Máx. 8Mb</p>
                    <p>.mp3         .m4a      .wav        ou qualquer arquivo de audio.</p>
                    <span class="error"> </span>
                    <form id="fileUpload">
                        <input type="file" id="fileToUp" name="Musica[file]">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div id="player">
            <div class="row">
                <div class="col-xs-8" id="playingText">
                    <p id="playingTitle">Tocando Agora:</p>
                    <p id="playingName"></p>
                </div>
            </div>
            <div class="row">

            </div>
            <audio id="player-content" controls>
            </audio>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2>Lista de músicas</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="flex" id="musicList">
        </div>
    </div>
</div>