import PlanqueRepository, {Planque, TypePlanque} from "../repository/PlanqueRepository";
import DeleteButton from "../component/DeleteButton";
import PaysRepository from "../repository/PaysRepository";
import Tab from "./Tab";

export default class PlanqueTab implements Tab<Planque>
{
	public selected: Planque;
	public models: Planque[];

	private readonly planqueRepo: PlanqueRepository;
	private readonly paysRepo: PaysRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly adresse: HTMLInputElement;
	private readonly pays: HTMLSelectElement;
	private readonly type: HTMLSelectElement;

	/**
	 * Initialize a new PlanqueTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("hideout-list") as HTMLUListElement;
		this.code = document.getElementById("hideout-header") as HTMLHeadingElement;
		this.adresse = document.getElementById("hideout-adresse") as HTMLInputElement;
		this.pays = document.getElementById("hideout-pays") as HTMLSelectElement;
		this.type = document.getElementById("hideout-type") as HTMLSelectElement;
		this.planqueRepo = new PlanqueRepository();
		this.paysRepo = new PaysRepository();

		this.selected = null;
		this.adresse.value = "";
		this.pays.value = null;
		this.type.value = null;
		document.getElementById("hideout-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("hideout-new").addEventListener("click", this.onEntryAdd.bind(this));

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
			// Planques
			this.models = await this.planqueRepo.getAll();
			this.list.innerHTML = "";
			for (const planque of this.models)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${planque.adresse}`;
				this.list.append(item);

				item.setAttribute("data-code", planque.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Planque, PlanqueRepository>(
					item, planque, this.planqueRepo);
				item.append(del.button);
			}

			// Pays
			const pays = await this.paysRepo.getAll();
			this.pays.innerHTML = "";
			for (const p of pays)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = p.libelle;
				item.setAttribute("data-code", p.code.toString());
				item.setAttribute("data-libelle", p.libelle);
				this.pays.appendChild(item);
			}
			M.FormSelect.init(this.pays, { dropdownOptions: { container:document.body } });

			// Type
			const typePlanques: Record<string, TypePlanque> = {};
			this.models.forEach((p: Planque) => typePlanques[p.typePlanque.libelle] = p.typePlanque);
			this.type.innerHTML = "";
			for (const typePlanque of Object.values(typePlanques))
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = typePlanque.libelle;
				item.setAttribute("data-code", typePlanque.code.toString());
				item.setAttribute("data-libelle", typePlanque.libelle);
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
			this.selected = {adresse: "", code: 0, pays: undefined, typePlanque: undefined};

		// Planque
		this.selected.adresse = this.adresse.value;

		// Pays
		if (!this.pays.selectedOptions[0]) return;
		this.selected.pays = {
			...this.selected?.pays,
			code: parseInt(this.pays.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.pays.selectedOptions[0].getAttribute("data-libelle")
		};

		// TypePlanque
		if (!this.type.selectedOptions[0]) return;
		this.selected.typePlanque = {
			...this.selected.typePlanque,
			code: parseInt(this.type.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.type.selectedOptions[0].getAttribute("data-libelle")
		};

		isNew ? await this.planqueRepo.add(this.selected)
			: await this.planqueRepo.update(this.selected);
		await this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		// Planque
		this.code.innerText = this.selected?.code ? `Planque ${this.selected?.code}` : "Nouvelle Planque";
		this.adresse.value = this.selected?.adresse ?? "";

		// Pays
		this.pays.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.pays?.libelle);
		M.FormSelect.init(this.pays, { dropdownOptions: { container:document.body } });

		// TypePlanque
		this.type.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.typePlanque?.libelle);
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
