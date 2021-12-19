var q = 1e3,t = (new Date).getTime() / q, d = t, e, s, g = 60;
function Tick() {
	d = (new Date).getTime() / q;
	e = 76896 + t - d;
	s = parseInt(e - (parseInt(e / g) * g));
	e = parseInt(e / g);
	if (0 > e || -10 > s) document.location.href = './?game_state=done&reason=timeout';
	document.getElementById('min').innerHTML = (0 > s ? (s*=-1, "-"): "") + e;
	document.getElementById('sec').innerHTML = (s < 10 ? "0" + s : s);
	setTimeout(Tick, 50);
}

function select(num) {
	
}