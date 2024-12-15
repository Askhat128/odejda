const burger = document.getElementById('burger');
const vmenu = document.getElementById('vmenu');

burger.addEventListener('click', () => {
	burger.classList.toggle('active');
	vmenu.classList.toggle('active');
});