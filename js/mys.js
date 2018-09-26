var ls = $('.myAswitch');
var ll = $('#login-link');
var sl = $('#signup-link');
var myswitch = $('.myswitch');
var e = $('.error')[0];
ll.click(function() {
    myswitch.css('display','none');
    ls[0].style.display="block";
});
sl.click(function() {
    myswitch.css('display','none');
    ls[1].style.display="block";
});
var close = $('.close');

close.click(function() {
    ls.css('display','none');
    myswitch.css('display','block');
    if(e.innerText=="") e.style.display='none';
});

window.onclick = function(event) {
    if (event.target == ls[0] || event.target == ls[1]) {
        ls.css('display','none');
        myswitch.css('display','block');
        if(e.innerText=="") e.style.display='none';
    }

}

if(e.innerText=="") e.style.display='none';