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
		if (a[0].toLowerCase() == b[0].toLowerCase()) {
			return 0;
		}
		n1 = parseFloat(a[0].toLowerCase());
		n2 = parseFloat(b[0].toLowerCase());
		if (isNaN(n1) && isNaN(n2)) {
			if (a[0].toLowerCase() > b[0].toLowerCase()) {
				return 1;
			} else {
				return -1;
			}
		} else if (!isNaN(n1) && !isNaN(n2)) {
			if (n1 > n2) {
				return 1;
			} else {
				return -1;
			}
		} else if (isNaN(n1) && !isNaN(n2)) {
			return 1;
		}
		return -1;
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