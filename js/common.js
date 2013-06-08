function addMoreText(target,template) {
	var container = document.getElementById(target);
	var newdiv = document.createElement('div');
	newdiv.innerHTML = document.getElementById(template).innerHTML;
	container.appendChild(newdiv);
}

function toggleDisplay(ele) {
	if (ele.style.display == 'none') {
		ele.style.display = "block";
	} else {
		ele.style.display = "none";
	}
}