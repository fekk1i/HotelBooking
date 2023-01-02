//edited by Adham ALAzzabi, Ali Fekki, Ramy Naiem , Waleed Ibrahim 
const searchItem = document.querySelector('#searchInput');
const searchBtn = document.querySelector('button#searchBtn');
const rooms = document.querySelectorAll('.room');
const mainSection = document.querySelector('.main-section');
function search() {
	console.log('hello', rooms);
	if (!searchItem.value) return;
	mainSection.innerHTML = '';
	let match = false;
	rooms.forEach(room=>{
		let title = room.querySelector('.card-title').innerText.toLowerCase();
		if(title.includes(searchItem.value.toLowerCase())){
			mainSection.appendChild(room)
			match = true;
		}
	});	
	if (!match) {
		mainSection.innerHTML = `
		<div class="d-flex mx-auto">
			<h3 class="text-danger text-center">No '${searchItem.value}' Found</h3>
		</div>`;	
	}
}

searchBtn.addEventListener('click', search)

document.addEventListener('keyup', (e)=>{
	if(e.keyCode !== 13) return;
	let isFocused = (document.activeElement === searchItem) 
	if(isFocused){
		this.search()
	}
});
