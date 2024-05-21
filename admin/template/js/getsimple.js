/* reverseOrder function */
(function() {
	Element.prototype.reverseOrder = function() {
		if (!this.parentNode) return;
		this.parentNode.insertBefore(this, this.parentNode.firstChild);
	};
})();

/* Capslock detection */
(function() {
	var defaults = {
		caps_lock_on: function() {},
		caps_lock_off: function() {},
		caps_lock_undetermined: function() {},
		mac_shift_hack: true,
		debug: false
	};

	function extend(target, source) {
		for (var key in source) {
			if (source.hasOwnProperty(key)) {
				target[key] = source[key];
			}
		}
		return target;
	}

	function capslock(options) {
		options = extend(defaults, options || {});
		this.addEventListener('keypress', function(e) {
			checkCapsLock(e, options);
		});
	}

	function checkCapsLock(e, options) {
		var ascii_code = e.which;
		var letter = String.fromCharCode(ascii_code);
		var upper = letter.toUpperCase();
		var lower = letter.toLowerCase();
		var shift_key = e.shiftKey;

		if (upper !== lower) {
			if (letter === upper && !shift_key) {
				options.caps_lock_on.call(e.target);
			} else if (letter === lower && !shift_key) {
				options.caps_lock_off.call(e.target);
			} else if (letter === lower && shift_key) {
				options.caps_lock_on.call(e.target);
			} else if (letter === upper && shift_key) {
				if (navigator.platform.toLowerCase().indexOf("win") !== -1) {
					options.caps_lock_off.call(e.target);
				} else if (navigator.platform.toLowerCase().indexOf("mac") !== -1 && options.mac_shift_hack) {
					options.caps_lock_off.call(e.target);
				} else {
					options.caps_lock_undetermined.call(e.target);
				}
			} else {
				options.caps_lock_undetermined.call(e.target);
			}
		} else {
			options.caps_lock_undetermined.call(e.target);
		}

		if (options.debug && console) {
			console.log("Ascii code: " + ascii_code);
			console.log("Letter: " + letter);
			console.log("Upper Case: " + upper);
			console.log("Shift key: " + shift_key);
		}
	}

	Element.prototype.capslock = function(options) {
		capslock.call(this, options);
	};
})();

/* Debugger */
var Debugger = {
	log: function(message) {
		try {
			console.log(message);
		} catch (exception) {
			return;
		}
	}
};

/* popit */
Element.prototype.popit = function(speed) {
	speed = speed || 500;
	if (!this.dataset.popped) {
		this.style.transition = `opacity ${speed}ms`;
		this.style.opacity = 0;
		setTimeout(() => {
			this.style.opacity = 1;
		}, speed);
		this.dataset.popped = true;
	}
	return this;
};

/* removeit */
Element.prototype.removeit = function(delay) {
	delay = delay || 5000;
	setTimeout(() => {
		this.style.transition = 'opacity 500ms';
		this.style.opacity = 0;
		setTimeout(() => {
			if (this.parentNode) {
				this.parentNode.removeChild(this);
			}
		}, 500);
	}, delay);
	return this;
};

/* Notifications */
function notifyOk(msg) {
	return notify(msg, 'ok');
}

function notifyWarn(msg) {
	return notify(msg, 'warning');
}

function notifyInfo(msg) {
	return notify(msg, 'info');
}

function notifyError(msg) {
	return notify(msg, 'error');
}

function notify(msg, type) {
	if (['ok', 'warning', 'info', 'error'].indexOf(type) !== -1) {
		var notifyDiv = document.createElement('div');
		notifyDiv.className = 'notify notify_' + type;
		var p = document.createElement('p');
		p.innerText = msg;
		notifyDiv.appendChild(p);
		document.querySelector('div.bodycontent').insertAdjacentElement('beforebegin', notifyDiv);
		return notifyDiv;
	}
}

function clearNotify() {
	var notifies = document.querySelectorAll('div.wrapper .notify');
	notifies.forEach(function(notify) {
		notify.remove();
	});
}

/* Utility Functions */
function basename(str) {
	return str.substring(0, str.lastIndexOf('/'));
}

function i18n(key) {
	return GS.i18n[key];
}

document.addEventListener('DOMContentLoaded', function() {
	var loadingAjaxIndicator = document.getElementById('loader');

	/* Listener for filter dropdown */
	function attachFilterChangeEvent() {

		if(document.getElementById('imageFilter')!==null){
		document.getElementById('imageFilter').addEventListener('change', function() {
			Debugger.log('attachFilterChangeEvent');
			loadingAjaxIndicator.style.display = 'block';
			var filterx = this.value;
			var rows = document.querySelectorAll("#imageTable tr");
			rows.forEach(function(row) {
				row.style.display = 'none';
			});
			if (filterx === 'Images') {
				document.querySelectorAll("#imageTable tr .imgthumb").forEach(function(img) {
					img.style.display = 'block';
				});
			} else {
				document.querySelectorAll("#imageTable tr .imgthumb").forEach(function(img) {
					img.style.display = 'none';
				});
			}
			document.getElementById('filetypetoggle').innerHTML = '&nbsp;&nbsp;/&nbsp;&nbsp;' + filterx;
			document.querySelectorAll("#imageTable tr." + filterx).forEach(function(row) {
				row.style.display = 'block';
			});
			document.querySelector("#imageTable tr:first-child").style.display = 'block';
			document.querySelectorAll("#imageTable tr.deletedrow").forEach(function(row) {
				row.style.display = 'none';
			});
			setTimeout(function() {
				loadingAjaxIndicator.style.display = 'none';
			}, 500);
		});
	}
}

	//upload.php
	attachFilterChangeEvent();

	//image.php 
	var copyKitTextArea = document.querySelector('textarea.copykit');

	if( document.getElementById('img-info') !==null){


	document.getElementById('img-info').addEventListener('change', function() {
		var codetype = this.value;
		var code = document.querySelector('p#' + codetype).innerHTML;
		var originalBG = copyKitTextArea.style.backgroundColor;
		var fadeColor = "#FFFFD1";
		copyKitTextArea.style.opacity = 0;
		setTimeout(function() {
			copyKitTextArea.innerHTML = code;
			copyKitTextArea.style.opacity = 1;
		}, 500);
	});

	document.addEventListener('click', function(e) {
		if (e.target.classList.contains('select-all')) {
			e.preventDefault();
			copyKitTextArea.focus();
			copyKitTextArea.select();
		}
	});

}

	//autofocus index.php & resetpassword.php fields on pageload
	var indexUserIdInput = document.querySelector("#index input#userid");
	if (indexUserIdInput) indexUserIdInput.focus();

	var resetPasswordUsernameInput = document.querySelector("#resetpassword input[name='username']");
	if (resetPasswordUsernameInput) resetPasswordUsernameInput.focus();

	var options = {
		caps_lock_on: function() {
			this.classList.add('capslock');
		},
		caps_lock_off: function() {
			this.classList.remove('capslock');
		},
		caps_lock_undetermined: function() {
			this.classList.remove('capslock');
		}
	};

	document.querySelectorAll("input[type='password']").forEach(function(input) {
		input.capslock(options);
	});

	// components.php
	document.querySelectorAll('.delcomponent').forEach((x,i)=>{
		x.addEventListener('click',(e)=>{
			e.preventDefault();
			confirm(delmsg+'?');
			x.parentElement.parentNode.parentNode.parentNode.parentNode.remove() 
		})
	});

	document.addEventListener('click', function(e) {
		if (e.target.id === 'addcomponent') {
			e.preventDefault();
			var id = document.getElementById('id').value;
			var newComponentHTML = '<div style="display:none;" class="compdiv" id="section-' + id + '"><table class="comptable"><tr><td><b>Title: </b><input type="text" class="text newtitle" name="title[]" value="" /></td><td class="delete"><a href="#" title="Delete Component:?" class="delcomponent" id="del-' + id + '" rel="' + id + '" >&times;</a></td></tr></table><textarea name="val[]"></textarea><input type="hidden" name="slug[]" value="" /><input type="hidden" name="id[]" value="' + id + '" /><div>';
			document.querySelector('.manyinputs').insertAdjacentHTML('beforeend', newComponentHTML);
			document.getElementById('section-' + id).reverseOrder();
			document.getElementById('section-' + id).popit();
			document.getElementById('section-' + id).style.display = 'block';
			id++;
			document.getElementById('id').value = id;
   
			document.querySelectorAll('.delcomponent').forEach((x,i)=>{
				x.addEventListener('click',(e)=>{
					e.preventDefault();
					confirm(delmsg+'?');
					x.parentElement.parentNode.parentNode.parentNode.parentNode.remove() 
				})
			});
		}
	});
	
		document.querySelectorAll("b.editable").forEach(function (element) {
			element.addEventListener("dblclick", function () {
				var t = this.innerHTML;
				var compDiv = this.closest('.compdiv');
				var compTitleInput = compDiv.querySelector("input.comptitle");
				var changeTitleDiv = document.createElement("div");
				changeTitleDiv.id = "changetitle";
				changeTitleDiv.innerHTML = '<b>Title: </b><input class="text newtitle titlesaver" name="title[]" value="' + t + '" />';
				this.after(changeTitleDiv);
				changeTitleDiv.querySelector('input').focus();
				compTitleInput.style.display = 'none';
				compDiv.querySelector("input.compslug").value = '';
				this.style.display = 'none';
			});
		});
   
		document.addEventListener("keyup", function (event) {
			if (event.target.classList.contains("titlesaver")) {
				var myval = event.target.value;
				var compDiv = event.target.closest('.compdiv');
				compDiv.querySelector(".compslugcode").innerHTML = "'" + myval.toLowerCase() + "'";
				compDiv.querySelector("b.editable").innerHTML = myval;
			}
		});
   
		document.addEventListener("focusout", function (event) {
			if (event.target.classList.contains("titlesaver")) {
				var myval = event.target.value;
				var compDiv = event.target.closest('.compdiv');
				compDiv.querySelector(".compslugcode").innerHTML = "'" + myval.toLowerCase() + "'";
				compDiv.querySelector("b.editable").innerHTML = myval;
				compDiv.querySelector("input.comptitle").value = myval;
				document.querySelectorAll("b.editable").forEach(function (editable) {
					editable.style.display = 'block';
				});
				var changeTitleDiv = document.getElementById("changetitle");
				if (changeTitleDiv) {
					changeTitleDiv.remove();
				}
			}
		});

});

//edit 
window.addEventListener("load",()=>{

if(document.querySelector('.edit-nav #metadata_toggle') !== null){
	document.querySelector('.edit-nav #metadata_toggle').addEventListener('click',e=>{
		e.preventDefault();

		if(document.querySelector('#metadata_window').style.display == 'none'){
			document.querySelector('#metadata_window').style.display="block";
		}else{
			document.querySelector('#metadata_window').style.display="none";
		}
	}) ;
}

if(document.querySelector('.edit-nav #filtertable') !== null){
	document.querySelector('#filter-search').style.display = 'none';

	document.querySelector('.edit-nav #filtertable').addEventListener('click',e=>{
		e.preventDefault();
		if(document.querySelector('#filter-search').style.display == 'none' ){
			document.querySelector('#filter-search').style.display="block";
		}else{
			document.querySelector('#filter-search').style.display="none";
		}
	}) ;

	const inputFind = document.querySelector('#filter-search #q');

	inputFind.addEventListener("keyup", e => {
		document.querySelectorAll('.highlight tr').forEach(c => {
			if (c.querySelector('td') !== null) {
				const names = c.querySelector('tr a').innerText;
				const newnames = names.toLowerCase();

				if (newnames.includes(inputFind.value)) {
				 
				} else {
					c.style.display = "none";
				};

				if (inputFind.value == "") {
					c.style.display = "";
				}
			};
		});
	});
}

if(document.querySelector('.edit-nav #show-characters') !== null){
	document.querySelector('.edit-nav #show-characters').addEventListener('click',e=>{
		e.preventDefault();

		document.querySelectorAll('.showstatus').forEach(x=>{
			x.classList.toggle('toggle');
		});
	}) ;
}

if(document.querySelector('body#upload')!==null){
	var gallery = new SimpleLightbox('.imgthumb a', {
		scrollZoom:false
	});
	
	document.querySelector('#new-folder form').style.display="none";
	document.querySelector('#createfolder').addEventListener('click',()=>{
		if(document.querySelector('#new-folder form').style.display=="none"){
			document.querySelector('#new-folder form').style.display="block"
		}else{
			document.querySelector('#new-folder form').style.display="none"
		}
    });
}
 
})