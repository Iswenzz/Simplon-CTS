const conHidden : HTMLCollectionOf<Element> = document.getElementsByClassName("hidden-when-connected");
const conVisible : HTMLCollectionOf<Element> = document.getElementsByClassName("visible-when-connected");

// displaying the correct widgets depending on the connected state
console.log(sessionStorage["apiKey"]);
if (sessionStorage["apiKey"]) { // already connected
	for (const el of conHidden) {
		el.setAttribute("hidden", "true");
	}
} else { // not connected
	for (const el of conVisible) {
		el.setAttribute("hidden", "true");
	}
}

// disconnecting
document.getElementById("logout").addEventListener("click", () => {
	if (sessionStorage["apiKey"]) {
		sessionStorage.clear();
		window.location.reload();
	}
});