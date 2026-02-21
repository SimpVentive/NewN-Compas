function getposdet(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Positions";
	document.getElementById("followdes").innerHTML ="Following are the position details";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/getposdet_archive?id=" + id, true);
	xmlhttp.send();
}

