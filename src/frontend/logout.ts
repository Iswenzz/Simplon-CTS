// disconnecting
document.getElementById("logout").addEventListener("click", () => {
	if (sessionStorage["apiKey"]) {
		sessionStorage.clear();
		window.location.reload();
	}
});