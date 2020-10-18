import SpecialiteRepository, {Specialite} from "../repository/SpecialiteRepository";
import DeleteButton from "../component/DeleteButton";
import Tab from "./Tab";
import {TypeMission} from "../repository/MissionRepository";

export default class SpecialiteTab implements Tab<Specialite>
{
	public selected: Specialite;
	public models: Specialite[];

	private readonly specialiteRepo: SpecialiteRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly libelle: HTMLInputElement;
	private readonly description: HTMLTextAreaElement;
	private readonly type: HTMLSelectElement;

	/**
	 * Initialize a new SpecialiteTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("specialite-list") as HTMLUListElement;
		this.code = document.getElementById("specialite-header") as HTMLHeadingElement;
		this.libelle = document.getElementById("specialite-libelle") as HTMLInputElement;
		this.description = document.getElementById("specialite-description") as HTMLTextAreaElement;
		this.type = document.getElementById("specialite-type") as HTMLSelectElement;
		this.specialiteRepo = new SpecialiteRepository();

		this.selected = null;
		this.libelle.value = "";
		this.description.value = "";
		this.type.value = null;
		document.getElementById("specialite-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("specialite-new").addEventListener("click", this.onEntryAdd.bind(this));

		this.initialize();
		this.renderEntryView();
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
				item.innerText = `${specialite.code} ${specialite.libelle}`;
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
			const typeMission: Record<string, TypeMission> = {};
			this.models.forEach((s: Specialite) => typeMission[s.typeMission.libelle] = s.typeMission);
			this.type.innerHTML = "";
			for (const specialite of Object.values(typeMission))
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = specialite.libelle;
				item.setAttribute("data-code", specialite.code.toString());
				item.setAttribute("data-libelle", specialite.libelle);
				this.type.appendChild(item);
			}
			M.FormSelect.init(this.type, { dropdownOptions: { container:document.body } });
		}
		catch (error)
		{
			console.log(error);
		}
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

		// TypeSpecialite
		if (!this.type.selectedOptions[0]) return;
		this.selected.typeMission = {
			...this.selected.typeMission,
			code: parseInt(this.type.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.type.selectedOptions[0].getAttribute("data-libelle")
		};

		isNew ? await this.specialiteRepo.add(this.selected)
			: await this.specialiteRepo.update(this.selected);
		await this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		this.code.innerText = this.selected?.code ? `Specialite ${this.selected?.code}` : "Nouvelle Specialite";
		this.libelle.value = this.selected?.libelle ?? "";
		this.description.value = this.selected?.description ?? "";
		this.type.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.typeMission?.libelle);
		M.FormSelect.init(this.type, { dropdownOptions: { container:document.body } });
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
