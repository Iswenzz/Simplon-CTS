import PlanqueRepository, {Planque, TypePlanque} from "../repository/PlanqueRepository";
import DeleteButton from "../component/DeleteButton";
import PaysRepository from "../repository/PaysRepository";

export default class PlanqueTab
{
	public selectedPlanque: Planque;
	public planques: Planque[];

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

		this.adresse.value = "";
		this.pays.value = null;
		this.type.value = null;
		document.getElementById("hideout-form").addEventListener("submit", this.submitModel.bind(this));

		this.initialize();
	}

	/**
	 * Render the tab content.
	 */
	public async initialize(): Promise<void>
	{
		try
		{
			// Planques
			this.planques = await this.planqueRepo.getAll();
			this.list.innerHTML = "";
			for (const planque of this.planques)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${planque.code} ${planque.adresse}`;
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
			M.FormSelect.init(this.pays);

			// Type
			const typePlanques: Record<string, TypePlanque> = {};
			this.planques.forEach((p: Planque) => typePlanques[p.typePlanque.libelle] = p.typePlanque);
			this.type.innerHTML = "";
			for (const typePlanque of Object.values(typePlanques))
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = typePlanque.libelle;
				item.setAttribute("data-code", typePlanque.code.toString());
				item.setAttribute("data-libelle", typePlanque.libelle);
				this.type.appendChild(item);
			}
			M.FormSelect.init(this.type);
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
		if (!this.selectedPlanque) return;

		this.selectedPlanque.adresse = this.adresse.value;

		if (!this.pays.selectedOptions[0]) return;
		this.selectedPlanque.pays = {
			...this.selectedPlanque.pays,
			code: parseInt(this.pays.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.pays.selectedOptions[0].getAttribute("data-libelle")
		};

		if (!this.type.selectedOptions[0]) return;
		this.selectedPlanque.typePlanque = {
			...this.selectedPlanque.typePlanque,
			code: parseInt(this.type.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.type.selectedOptions[0].getAttribute("data-libelle")
		};

		await this.planqueRepo.update(this.selectedPlanque);
		await this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		this.code.innerText = `Planque ${this.selectedPlanque.code}`;
		this.adresse.value = this.selectedPlanque.adresse;
		this.pays.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selectedPlanque.pays?.libelle);
		M.FormSelect.init(this.pays);
		this.type.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selectedPlanque.typePlanque?.libelle);
		M.FormSelect.init(this.type);
	}

	/**
	 * Callback on entry click.
	 * @param sender - The entry element.
	 */
	public onEntryClick(sender: HTMLLIElement): void
	{
		const idx: number = parseInt(sender.getAttribute("data-code"), 10);
		this.selectedPlanque = this.planques.find(p => p.code === idx);
		this.renderEntryView();
	}
}
