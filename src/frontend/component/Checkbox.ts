export default class Checkbox {
	private input: HTMLInputElement;
	private label: HTMLLabelElement;
	private text: HTMLSpanElement;

	public constructor(label: string, value: string) {
		this.label = document.createElement("label");
		this.input = document.createElement("input");
		this.label.append(this.input);
		this.input.setAttribute("type", "checkbox");
		this.input.classList.add("filled-in");
		this.input.setAttribute("value", value);
		this.text = document.createElement("span");
		this.label.append(this.text);
		this.text.innerText = label;
	}

	public getContainer(): HTMLLabelElement {
		return this.label;
	}

	public getLabel(): HTMLSpanElement {
		return this.text;
	}

	public getInput(): HTMLInputElement {
		return this.input;
	}
}