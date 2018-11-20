var scanner;
var activeCameraId;
var aCameras;

function startQRReader(){
	self.scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });
	self.scanner.addListener('scan', function (content) {
		var input = document.getElementById('qrcode-text');
		input.value = content;
		document.getElementById("btnCloseModal").click();
	});
	Instascan.Camera.getCameras().then(function (cameras) {
		self.aCameras = cameras.slice(0,cameras.length);
		if (cameras.length > 0) {
			self.activeCameraId = cameras[0].id;
			self.scanner.start(cameras[0]);
			const list = document.getElementById('listCameras');
			let aux = 0;
			cameras.forEach(function(cam){
				let node = document.createElement("a");
				node.id = cam.id;
				node.classList.add("camNode");
				node.classList.add("collection-item");
				node.addEventListener("click", changeCam);
				if (aux === 0) {
					node.classList.add("active");
				}
				node.setAttribute("value", aux++);
				var textnode = document.createTextNode(cam.name);
				node.appendChild(textnode);
				list.appendChild(node);
			});
		} else {
			console.error('No cameras found.');
		}
	}).catch(function (e) {
		console.error(e);
	});
}

function changeCam(){
	const _this = this;
	const aCamNodes = document.querySelectorAll('.camNode');
	aCamNodes.forEach(function(cam){
		cam.classList.remove("active");
	});
	_this.classList.add("active");
	aCameras.forEach(function(cam){
		if (cam.id === _this.id) {
			self.activeCameraId = _this.id;
			self.scanner.start(cam);
		}
	});
}

function closeQRReader(){
	self.scanner.stop();
	const listCameras = document.getElementById('listCameras');
	for (var i = listCameras.children.length - 1; i >= 0; i--) {
		listCameras.removeChild(listCameras.children[i]);
	}
}

function create(){
	var data = document.getElementById("data").value;
	document.getElementById("qrimage").innerHTML="<img src='https://chart.googleapis.com/chart?chs=250x250&cht=qr&choe=ISO-8859-1&chl="+encodeURIComponent(data)+"'/>";
}