import Model from "../repository/Model";

/**
 * Default interface for an admin tab.
 */
export default interface Tab<M extends Model>
{
	selected: M;
	models: M[];

	/**
	 * Render the tab content.
	 */
	initialize(): Promise<void>;

	/**
	 * Update the selected model data and send it to the backend.
	 */
	submitModel(e: Event): Promise<void>;

	/**
	 * Render the entry to the DOM.
	 */
	renderEntryView(): void;

	/**
	 * Callback on entry click.
	 * @param sender - The entry element.
	 */
	onEntryClick(sender: HTMLElement): void;
}
