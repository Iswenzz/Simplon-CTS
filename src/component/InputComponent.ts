export default class InputComponent
{
	private readonly container : HTMLDivElement;
	private readonly label : HTMLLabelElement;
	private readonly input : HTMLInputElement | HTMLTextAreaElement;

	/**
	 * Initialize a new input component.
	 * @param type - The input type.
	 * @param id - The input id.
	 * @param label - The input label.
	 */
	public constructor(type: string, id: string, label: string)
	{
		this.container = document.createElement("div");
		this.label = document.createElement("label");
		this.container.append(this.label);
		this.input = document.createElement("input");
		this.container.append(this.input);

		this.input.setAttribute("type", type);
		this.input.setAttribute("id", id);
		this.label.setAttribute("for", id);
		this.label.innerText = label;
	}

	/**
	 * Get the input container.
	 */
	public getContainer(): HTMLDivElement
	{
		return this.container;
	}

	/**
	 * Get the input label.
	 */
	public getLabel(): HTMLLabelElement
	{
		return this.label;
	}

	/**
	 * Get the input element.
	 */
	public getInput(): HTMLInputElement | HTMLTextAreaElement
	{
		return this.input;
	}
}
