export default class InputComponent {
	private container : HTMLDivElement;
	private label : HTMLLabelElement;
	private input : HTMLInputElement | HTMLTextAreaElement;

	public constructor(type: string, id: string, label: string) {
		
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

	public getContainer(): HTMLDivElement {
		return this.container;
	}

	public getLabel(): HTMLLabelElement {
		return this.label;
	}

	public getInput(): HTMLInputElement | HTMLTextAreaElement {
		return this.input;
	}

}