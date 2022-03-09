
  
var config = {
  apiKey: "AIzaSyAKBpfXoC2TQq7hUWdQzLrWo43daEKhOew",
  authDomain: "wundoo-social.firebaseapp.com",
  projectId: "wundoo-social",
  storageBucket: "wundoo-social.appspot.com",
  messagingSenderId: "160690801837",
  appId: "1:160690801837:web:22892c9f9e7fe0d95e8a24",
  measurementId: "G-3G62DSZZ8T"
};
var VapidKey = 'BBrxGlwyNtwy7_6FPMXqRsQtAXF7BpAzDjLKiBPgjF5B0AzhZPy_OGWQkL2nhZ3OiYxk7DD1xJ_VOo9ajexy8vc';
var messaging = null;

$(document).ready(function($) {
    

    // Initialize Firebase
    firebase.initializeApp(config);

    messaging = firebase.messaging();

    messaging.usePublicVapidKey(VapidKey);
    if (Notification.permission === 'default' || Notification.permission === 'undefined') {
        messaging.requestPermission().then(function() {
            messaging.getToken().then(function (currentToken) {
                console.log('currentToken: '+currentToken);
                if (currentToken) {
                    registerToken(currentToken);
                } else {
                    console.log('註冊失敗請檢查相關設定.');
                }
            }).catch(function (err) {
                console.log("跟 Server 註冊失敗 原因:" + err + "<br>");
            });
        }).catch(function(err) {
            console.log('Unable to get permission to notify.', err);
        });
    }

    //Front
    messaging.onMessage(function (payload) {
        console.log(event.data.title+" , "+event.data.message);
        // displayNoti(payload.data.title, payload.data.message);
        // notiBadge();
    });

    //Background
    navigator.serviceWorker.addEventListener('message', function(event) {
        
        if (event.data.hasOwnProperty("title")) {
            console.log(event.data.title+" , "+event.data.message);
            // displayNoti(event.data.title, event.data.message);
            // notiBadge();
        }
    });
});

function notiBadge(){
    if ($(".notification").length > 0) {
        $.ajax({
            url: BASE_URL+"dashboard/get_noti",
            data: {},
            type: "POST",
            dataType: "json",
            success: function(msg){
                $(".notification span").html(msg.length);
                $(".notification ~ .dropdown-menu").html("");
                for (var i = 0; i < msg.length; i++) {
                    var item = msg[i];
                    $("<div/>").addClass('menu-item').attr({"data-url":item.url}).append('<strong>'+item.title+'</strong>'+item.content+'<div class="time">'+item.create_date+'</div>').appendTo($(".notification ~ .dropdown-menu"));
                }

                $(".menu-item").on('click', function(event) {
                    var url = $(this).attr("data-url");
                    if (url != "") location.href = url;
                });
            },
            error:function(xhr, ajaxOptions, thrownError){ 
                
            },
            complete:function(){
            }
        });
    }
}

function registerToken(token){
    $.ajax({
        url: BASE_URL+"dashboard/register_token",
        data: {
            token: token
        },
        type: "POST",
        dataType: "json",
        success: function(msg){
            
        },
        error:function(xhr, ajaxOptions, thrownError){ 
            
        },
        complete:function(){
        }
    });
}

function displayNoti(title, msg){
    var notifyConfig = {
      body: msg,
      icon: 'assets/img/icon.png'
    };

    var audio = new Audio('assets/noti.mp3');
    audio.play();

    if (Notification.permission === 'granted') 
        var notification = new Notification(title, notifyConfig);
    
}

function loadScript(url, callback)
{
    // Adding the script tag to the head as suggested before
    var head = document.head;
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;

    // Then bind the event to the callback function.
    // There are several events for cross browser compatibility.
    script.onreadystatechange = callback;
    script.onload = callback;

    // Fire the loading
    head.appendChild(script);
}