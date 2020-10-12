export default class Checkbox
{
	private readonly input: HTMLInputElement;
	private readonly label: HTMLLabelElement;
	private readonly text: HTMLSpanElement;
	private codeTarget: number | null; 		// ex: mission qu'on est en train de modifier
	private readonly codeProperty: number;	// ex: un agent qu'on affecte à la mission

	/**
	 * Initialize a new Checkbox component.
	 * @param label - label (texte) pour la checkbox
	 * @param value - value (code) pour la chekcbox
	 * @param codeTarget - code pour la cible (ex: la mission qu'on modifie) - peut être inconnu
	 * @param codeProperty - code pour la propriété représentée par la checkbox (ex: un agent qu'on affecte à la mission)
	 */
	public constructor(label: string, value: string, codeTarget: number | null, codeProperty: number)
	{
		this.label = document.createElement("label");
		this.input = document.createElement("input");
		this.label.append(this.input);
		this.input.setAttribute("type", "checkbox");
		this.input.classList.add("filled-in");
		this.input.setAttribute("value", value);
		this.text = document.createElement("span");
		this.label.append(this.text);
		this.text.innerText = label;

		this.codeTarget = codeTarget;
		this.codeProperty = codeProperty;
	}

	/**
	 * Get the container element.
	 */
	public getContainer(): HTMLLabelElement
	{
		return this.label;
	}

	/**
	 * Get the label element.
	 */
	public getLabel(): HTMLSpanElement
	{
		return this.text;
	}

	/**
	 * Get the input element.
	 */
	public getInput(): HTMLInputElement
	{
		return this.input;
	}

	/**
	 * Get the key.
	 */
	public getKey(): {codeTarget: number | null, codeProperty: number}
	{
		return {codeProperty: this.codeProperty, codeTarget: this.codeTarget};
	}

	/**
	 * Set the code target.
	 * @param c - The code.
	 */
	public setCodeTarget(c: number): void
	{
		this.codeTarget = c;
	}
}