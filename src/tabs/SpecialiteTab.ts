import SpecialiteRepository, {Specialite} from "../repository/SpecialiteRepository";
import DeleteButton from "../component/DeleteButton";
import Tab from "./Tab";
import TypeMissionRepository, {TypeMission} from "../repository/TypeMissionRepository";
import SelectComponent from "../component/SelectComponent";

export default class SpecialiteTab implements Tab<Specialite>
{
	public selected: Specialite;
	public models: Specialite[];
	public modelsTypeMission: TypeMission[];

	private readonly specialiteRepo: SpecialiteRepository;
	private readonly typeMissionRepo: TypeMissionRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly libelle: HTMLInputElement;
	private readonly description: HTMLTextAreaElement;
	private readonly type: SelectComponent<TypeMission>;

	/**
	 * Initialize a new SpecialiteTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("specialite-list") as HTMLUListElement;
		this.code = document.getElementById("specialite-header") as HTMLHeadingElement;
		this.libelle = document.getElementById("specialite-libelle") as HTMLInputElement;
		this.description = document.getElementById("specialite-description") as HTMLTextAreaElement;
		this.type = new SelectComponent<TypeMission>(document.getElementById("specialite-type") as HTMLSelectElement);

		this.specialiteRepo = new SpecialiteRepository();
		this.typeMissionRepo = new TypeMissionRepository();

		this.selected = null;
		this.libelle.value = "";
		this.description.value = "";

		document.getElementById("specialite-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("specialite-new").addEventListener("click", this.onEntryAdd.bind(this));
		document.getElementById("specialite-tab").addEventListener("click", this.initialize.bind(this));
	}

	/**
	 * Render the tab content.
	 */
	public async initialize(): Promise<void>
	{
		try
		{
			// Specialites
			this.models = await this.specialiteRepo.getAll();
			this.list.innerHTML = "";
			for (const specialite of this.models)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${specialite.libelle}`;
				this.list.append(item);

				item.setAttribute("data-code", specialite.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Specialite, SpecialiteRepository>(
					item, specialite, this.specialiteRepo);
				item.append(del.button);
			}

			// Type
			this.modelsTypeMission = await this.typeMissionRepo.getAll();
			this.type.initialize(this.modelsTypeMission, "libelle");
		}
		catch (error)
		{
			console.log(error);
		}
		this.renderEntryView();
	}

	/**
	 * Update the selected model data and send it to the backend.
	 */
	public async submitModel(e: Event): Promise<void>
	{
		e.preventDefault();
		const isNew = !this.selected;
		if (isNew)
			this.selected = {code: 0, description: "", libelle: "", typeMission: undefined};

		// Specialite
		this.selected.libelle = this.libelle.value;
		this.selected.description = this.description.value;
		this.selected.typeMission = this.type.getSelection() ?? this.selected.typeMission;

		isNew ? await this.specialiteRepo.add(this.selected)
			: await this.specialiteRepo.update(this.selected);
		await this.initialize();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		// Specialite
		this.code.innerText = this.selected?.code ? `Specialite ${this.selected?.code}` : "Nouvelle Specialite";
		this.libelle.value = this.selected?.libelle ?? "";
		this.description.value = this.selected?.description ?? "";
		this.type.render(this.selected?.typeMission?.code);
	}

	/**
	 * Callback on entry click.
	 * @param sender - The entry element.
	 */
	public onEntryClick(sender: HTMLLIElement): void
	{
		const idx: number = parseInt(sender.getAttribute("data-code"), 10);
		this.selected = this.models.find(p => p.code === idx);
		this.renderEntryView();
	}

	/**
	 * Callback on entry add.
	 */
	public onEntryAdd(): void
	{
		this.selected = null;
		this.renderEntryView();
	}
}
