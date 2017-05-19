function ChangeCardValue(val, state)
{
	cardval = document.getElementById(val);
	cardstate = document.getElementById(state);

	if (cardval.value == 1) {
		cardval.value = 0;
		cardstate.innerHTML = "Hold";
	}else{
		cardval.value = 1;
		cardstate.innerHTML = "";
	}
}

var CARDWIDTH = 140;

function turn(elem, src) {
	$(elem).animate({
        width: 0,
        marginLeft: CARDWIDTH / 2,
        marginRight: CARDWIDTH / 2
    }, function () {
        this.src = src
        $(this).animate({
            width: CARDWIDTH,
            marginLeft: 0,
            marginRight: 0
        })
    })
}

$(document).ready(function(){
	var audio1 = new Audio($('#flipCard').attr('src'));
	var audio2 = new Audio($('#flipCard').attr('src'));
	var audio3 = new Audio($('#flipCard').attr('src'));
	var audio4 = new Audio($('#flipCard').attr('src'));
	var audio5 = new Audio($('#flipCard').attr('src'));

	var c0 = function () {turn('#0', $('#o0').attr('src')); };
	var c1 = function () {turn('#1', $('#o1').attr('src')); };
	var c2 = function () {turn('#2', $('#o2').attr('src')); };
	var c3 = function () {turn('#3', $('#o3').attr('src')); };
	var c4 = function () {turn('#4', $('#o4').attr('src')); };
	

	var s0 = function() {audio1.play();};
	var s1 = function() {audio2.play();};
	var s2 = function() {audio3.play();};
	var s3 = function() {audio4.play();};
	var s4 = function() {audio5.play();};

	setTimeout(c0, 0);
	setTimeout(s0, 0);
	
	setTimeout(c1, 600);
	setTimeout(s1, 600);
	
	setTimeout(c2, 1200);
	setTimeout(s2, 1200);

	setTimeout(c3, 1800);
	setTimeout(s3, 1800);

	setTimeout(c4, 2400);
	setTimeout(s4, 2400);
});