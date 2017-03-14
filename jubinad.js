//window.addEventListener("load", function() {
//window.addEventListener("DOMContentLoaded", function() {
    //mida teha kui leht on laetud
//})
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
