const disconnectLink = document.getElementById("disconnect") as HTMLLinkElement;
const connectLink = document.getElementById("connect") as HTMLLinkElement;

// displaying the correct connect / disconnect link
console.log(sessionStorage["apiKey"]);
if (sessionStorage["apiKey"]) { // already connected
	connectLink.setAttribute("hidden", "true");
} else {
	disconnectLink.setAttribute("hidden", "true");
}

// disconnecting
disconnectLink.addEventListener("click", () => {
	if (sessionStorage["key"]) {
		sessionStorage.clear();
	}
});