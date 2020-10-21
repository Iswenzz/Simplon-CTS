import * as daysjs from "dayjs";

/**
 * Materialize date picker.
 */
export default class DatePickerComponent
{
	public picker: HTMLInputElement;

	/**
	 * Initialize a new DatePickerComponent.
	 * @param picker - The picker element.
	 */
	public constructor(picker: HTMLInputElement)
	{
		this.picker = picker;
	}

	/**
	 * Render the date picker.
	 * @param date - The selected date.
	 * @param format - The format to output.
	 */
	public render(date: string, format?: string): void
	{
		this.picker.value = date ?? "";
		M.Datepicker.init(this.picker, {
			container: document.body,
			format: format ?? "yyyy-mm-dd",
			defaultDate: daysjs(date).toDate(),
			setDefaultDate: true
		});
	}
}
