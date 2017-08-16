const PROJECT = "/imdj/";

var dropZone;
var musicHandler;
var musicPlayer;

$(function () {
    $('#logar').on('click', function () {
        $('#cadastro-form').animate({opacity: 0, 'marginTop': '-120px'}, 800, function () {
            $('#cadastro-form').removeClass('active');
            $('#login-form').addClass('active').animate({opacity: 1, 'marginTop': '30px'}, 800);
        });
    });
    $('#cadastrar').on('click', function () {
        $('#login-form').animate({opacity: 0, 'marginTop': '-120px'}, 800, function () {
            $('#login-form').removeClass('active');
            $('#cadastro-form').addClass('active').animate({opacity: 1, 'marginTop': '-20px'}, 800);
        });
    });

    if(localStorage.getItem('token') === "null" || localStorage.getItem('id') === "null"){
        window.location.href =PROJECT+'site/load';
    }

    musicPlayer = new MusicPlayer($('#player-content'));
    musicHandler = new MusicHandler();
    dropZone = new DropZone($('#dropZone'));

});

class DropZone {
    constructor(context) {
        this.dropZone = context;
        this.file;
        this.init();
    }

    init() {
        let $this = this;
        $("body").on('dragover', function (e) {
            e.preventDefault();
            $this.dragEnter(e);
        });
        $("body").on('dragenter', function (e) {
            e.preventDefault();
            $this.dragEnter(e);
        });
        $("body").on('dragleave', function (e) {
            e.preventDefault();
            $this.dragLeave(e);
        });
        $("body").on('drop', function (e) {
            e.preventDefault();
            $this.drop(e);
        });
    }

    dragEnter(e) {
        this.dropZone.css('background-color', 'rgba(45,45,45,0.7)');
    }

    dragLeave(e) {
        this.dropZone.css('background-color', 'rgba(35,35,35,1)');
    }

    drop(e) {
        this.dropZone.css('background-color', 'rgba(35,35,35,1)');
        this.file = e.originalEvent.dataTransfer.files[0];
        this.validate();
    }

    validate() {
        console.log(this.file);
        if (this.file.size / 1024 > 8192) {
            $('#dropZone .error').html("Só são permitidos arquivos até 8Mb.");
            return;
        } else if (!this.file.type.match('audio/')) {
            $('#dropZone .error').html("Só são permitidos arquivos de audio.");
            return;
        }
        $('#dropZone .error').html("");
        musicHandler.save(this.file);
    }

}

class MusicHandler {

    constructor() {
        this.get();
    }

    get() {
        let $this = this;
        fetch(PROJECT + 'api/default', {
            headers: {
                // 'Accept':'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem("token")
            },
            method: 'GET'
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (result) {
                $("#musicList").html("");
                for(let i = 0; i < result.length ; i++){
                    let div = '<div class="music" data-id="'+result[i].id+'" data-arquivo="'+result[i].file+'" data-extensao="'+result[i].extensao+'" data-nome="'+result[i].nome+'">'+
                        '<div class="front">'+
                    '<img src="'+PROJECT+'images/fileImg.png">'+
                '<div class="nome">'+result[i].nome+'</div>'+
                    '</div>'+
                    '</div>';
                    $("#musicList").append(div);
                }
                $this.setLink();
            });
    }

    select(id) {
        fetch(PROJECT + 'api/default/' + id, {
            headers: {
                // 'Accept':'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem("token")
            },
            method: 'GET'
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (result) {
                console.log(result);
            });
    }

    save(file) {
        let $this = this;
        let form = new FormData();
        // $("#fileToUp")[0].files[0] = this.file;
        form.set('Musica[file]', file, file.name);
        fetch(PROJECT + 'api/default', {
            headers: {
                // 'Accept':'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem("token")
            },
            method: 'POST',
            body: form
        })
            .then(function () {
                $this.get();
            });
    }

    setLink(){
        $.each($('.music'), function (obj) {
            $($('.music')[obj]).on('click', function (click) {
                musicPlayer.setMusic($($('.music')[obj]).data('arquivo'),$($('.music')[obj]).data('extensao'));
                $('#playingName').html($($('.music')[obj]).data('nome'));
                let playList = [];
                for(let y = obj ; y < $('.music').length ; y++){
                    playList.push($('.music')[y]);
                    musicPlayer.atual = 0;
                }
                musicPlayer.setPlayList(playList);
            });
        });
    }

}

class MusicPlayer{

    constructor(context){
        this.context = context;
        this.audio = this.context[0];
        this.audio.volume = 0;
        this.playList;
        this.atual = 0;
    }

    setMusic(file, extension){
        let $this = this;
        this.context.animate({volume:0},800, function () {
            $this.audio.src = PROJECT+'usuarios/'+localStorage.getItem('id')+'/'+file+extension;
            $this.play();
        });
    }

    play(){
        let $this = this;
        this.context.animate({volume:1},800, function () {
            $this.audio.play();
            $this.audio.autoplay = true;
        });
    }

    setPlayList(list){
        this.playList = list;
        let $this = this;
        this.context.on('ended',function () {
            console.log('end');
            $this.atual++;
            if($this.atual < $this.playList.length){
                $this.setMusic($($this.playList[$this.atual]).data('arquivo'),$($this.playList[$this.atual]).data('extensao'));
                $('#playingName').html($($this.playList[$this.atual]).data('nome'));
            }
        });
    }

}