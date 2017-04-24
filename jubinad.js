function focusTextArea() {
$("#txtArea").focus();
}
function imgClick(){
    $('.pic').on('click', function () {
        var tmpImg = new Image();
        var src = $(this).attr('src');
        tmpImg.src=src;
        var orgWidth = tmpImg.width;
        var orgHeight = tmpImg.height;
        if(orgWidth>$(window).width()-200 || orgHeight > $(window).height()-200) {
            var picAspect = orgWidth / orgHeight;
            var newWidth;
            var newHeight;
            if (picAspect > 1) {
                newWidth = $(window).width() - 200;
                newHeight = newWidth/picAspect
                if(newHeight>$(window).height()-200){
                    newHeight = $(window).height()-200;
                    newWidth = newHeight*picAspect;
                }
            }
            else if (picAspect < 1) {
                newHeight = $(window).height() - 200;
                newWidth = newHeight*picAspect;
                if(newWidth>$(window).width() - 200){
                    newWidth = $(window).width() - 200;
                    newHeight = newWidth/picAspect
                }
            }
            $('.bigPic').animate({"opacity": "1"}, 300).css("display", "block").width(newWidth).height(newHeight);
        }
        else {
            $('.bigPic').animate({"opacity": "1"}, 300).css("display", "block").width(orgWidth).height(orgHeight);
        }

        $('#bigPicInside').attr("src", src)
    });
    $('.bigPic').on('click', function () {
        $('.bigPic').css({"display": "none", "opacity": "0"});
    });
}
window.onload = function() {
    imgClick();
    focusTextArea();
}
var re = /^\w+$/;
function checkFormNoUser(form) {
    re = /^\s*$/;
    if (re.test(form.comment.value)) {
        alert("Error:  Textarea can not be empty!");
        form.comment.focus();
        return false;
    }
    return true;
}
function checkForm(form) {
  re = /^\w+$/;
  if(!re.test(form.user.value)) {
    alert("Error:  Username must contain only letters, numbers and underscores!");
    form.user.focus();
    return false;
  }
  re = /^\s*$/;
  if (re.test(form.comment.value)) {
    alert("Error:  Textarea can not be empty!");
    form.comment.focus();
    return false;
  }
  return true;
}
function pressed(e) {
  if ( (window.event ? event.keyCode : e.which) === 13 && !e.shiftKey) {
    e.preventDefault();
    document.getElementById('submit_button').click();
  }
}
function active_button(lk) {
  var el = document.getElementById(lk);
  el.style.color = "red";
}
