function addMoreText(target, template) {
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

function sortTable(table_id, sort_child_name, sort_order) {
	selector = '[name=' + sort_child_name + ']';

	table = document.getElementById(table_id);

	rowsArray = new Array();
	rows = table.children;
	for (a = 0, b = 0; a < rows.length; a++) {
		if (rows[a].querySelector(selector) != null) {
			rowsArray[b] = new Array();
			rowsArray[b][0] = rows[a].querySelector(selector).textContent;
			rowsArray[b][1] = rows[a].outerHTML;
			b++;
			table.removeChild(rows[a]);
			a--;
		}
	}

	rowsArray.sort(function(a, b) {
		if (a == b)
			return 0;
		n1 = parseFloat(a);
		n2 = parseFloat(b);
		if (isNaN(n1) && isNaN(n2)) {
			return (a > b) ? 1 : 0;
		} else if (!isNaN(n1) && !isNaN(n2)) {
			return (n1 > n2) ? 1 : 0;
		} else if (isNaN(n1) && !isNaN(n2)) {
			return 1;
		}
		return 0;
	});

	if (sort_order == 'desc') {
		rowsArray.reverse();
	}

	sTable = "";
	for (a = 0; a < rowsArray.length; a++) {
		sTable = sTable + rowsArray[a][1];
	}
	table.innerHTML += sTable;
}