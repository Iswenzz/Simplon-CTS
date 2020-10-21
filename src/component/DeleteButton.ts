import Repository from "../repository/Repository";
import Model from "../repository/Model";

export default class DeleteButton<M extends Model, R extends Repository<M>>
{
	private readonly _button: HTMLButtonElement;
	private readonly repository: R;
	private readonly model: M;

	/**
	 * Creates a new button that removes the target element when clicked.
	 * @param target - Target element to be removed.
	 * @param model - The model instance.
	 * @param repository - The API repository to use.
	 */
	public constructor(target : HTMLElement, model: M, repository: R)
	{
		this.repository = repository;
		this.model = model;

		this._button = document.createElement("button");
		this._button.classList.add("btn", "visible-when-connected", "waves-ripple", "waves-effect");
		this._button.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><path d=\"M424 64h-88V48a48 48 0 0 0-48-48h-64a48 48 0 0 0-48 48v16H88a40 40 0 0 0-40 40v56a16 16 0 0 0 16 16h8.7l13.8 290.3a48 48 0 0 0 47.9 45.7h243a48 48 0 0 0 47.9-45.7L448 176a16 16 0 0 0 16-16v-56a40 40 0 0 0-40-40zM208 48a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v16h-96zM80 104a8 8 0 0 1 8-8h336a8 8 0 0 1 8 8v40H80zm313.5 360.8a16 16 0 0 1-16 15.2h-243a16 16 0 0 1-16-15.2L104.8 176h302.4z\"/><use href=\"#B\"/><use href=\"#B\" x=\"80\"/><use href=\"#B\" x=\"-80\"/><defs><path id=\"B\" d=\"M256 448a16 16 0 0 0 16-16V224a16 16 0 1 0-32 0v208a16 16 0 0 0 16 16z\"/></defs></svg>";
		this._button.addEventListener("click", this.onButtonClick.bind(this));
	}

	/**
	 * Callback on delete button click.
	 * Remove the html button from the DOM and delete the model on the backend.
	 */
	public async onButtonClick(): Promise<void>
	{
		this.button.parentElement.remove();
		await this.repository.delete(this.model);
	}

	/**
	 * Get the HTML button element.
	 */
	public get button(): HTMLButtonElement
	{
		return this._button;
	}
}
