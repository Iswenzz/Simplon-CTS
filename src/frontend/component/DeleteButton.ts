export default class DeleteButton {
	private button : HTMLButtonElement;
	private target : HTMLElement;

	/**
	 * Creates a new button that removes the target element when clicked.
	 * @param target element to be removed
	 */
	constructor(target : HTMLElement) {
		this.button = document.createElement("button");

		this.target = target;
		this.button.classList.add("btn");
		this.button.classList.add("visible-when-connected");

		// TODO ajouter icône poubelle

		this.button.addEventListener("click", () => {
			this.target.remove();
			// TODO delete de la base
		});
	}

	public getTarget() : HTMLElement {
		return this.target;
	}

	public getButton(): HTMLButtonElement {
		return this.button;
	}
}