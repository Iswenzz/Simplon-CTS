export default class DeleteButton extends HTMLButtonElement {
	private target : HTMLElement;

	/**
	 * Creates a new button that removes the target element when clicked.
	 * @param target element to be removed
	 */
	constructor(target : HTMLElement) {
		super();

		this.target = target;
		this.classList.add("btn");
		this.classList.add("visible-when-connected");

		this.addEventListener("click", () => {
			this.target.remove();
		});
	}

	public getTarget() : HTMLElement {
		return this.target;
	}
}