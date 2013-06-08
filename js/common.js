function addMoreText() {
	var container = document.getElementById('servers');
	var newdiv = document.createElement('div');
	newdiv.innerHTML = document.getElementById('server-tpl').innerHTML;
	container.appendChild(newdiv);
}

function toggleDisplay(ele) {
	if (ele.style.display == 'none') {
		ele.style.display = "block";
	} else {
		ele.style.display = "none";
	}
}