import Model from "../repository/Model";

/**
 * Materialize select component.
 */
export default class SelectComponent<D extends Model>
{
	public select: HTMLSelectElement;
	public data: D[];

	/**
	 * Initialize a new Materialize select component.
	 * @param container - The select element.
	 * @param data - The options data.
	 */
	public constructor(container: HTMLSelectElement, data?: D[])
	{
		this.select = container;
		this.data = data;
	}

	/**
	 * Initialize the component.
	 * @param data - The options data.
	 * @param labelArgs - The options key to render in the label. I.E "code", "libelle"
	 */
	public initialize<K extends keyof D>(data?: D[], ...labelArgs: K[]): void
	{
		this.data = data;
		this.select.innerHTML = "";
		for (const d of data)
		{
			const item = document.createElement("option") as HTMLOptionElement;
			labelArgs.forEach(k => item.innerText += d[k] + " ");
			item.setAttribute("data-code", d.code.toString());
			this.select.appendChild(item);
		}
		M.FormSelect.init(this.select, { dropdownOptions: { container:document.body } });
	}

	/**
	 * Render the select element.
	 * @param code - Select a specific option from the model code.
	 */
	public render(code?: number): void
	{
		if (code === undefined) return;
		this.select.childNodes.forEach((i: HTMLOptionElement) =>
			i.selected = i.getAttribute("data-code") === code.toString());
		M.FormSelect.init(this.select, { dropdownOptions: { container:document.body } });
	}

	/**
	 * Get the element first selection.
	 */
	public getSelection(): D
	{
		if (!this.select.selectedOptions.length)
			return null;
		return this.data.find(i =>
			i.code === parseInt(this.select.selectedOptions[0].getAttribute("data-code"), 10));
	}

	/**
	 * Get the element selections.
	 */
	public getSelections(): D[]
	{
		if (!this.select.selectedOptions.length)
			return null;
		return this.data.filter(i =>
			i.code === parseInt(this.select.selectedOptions[0].getAttribute("data-code"), 10));
	}
}
