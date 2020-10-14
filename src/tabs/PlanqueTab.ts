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
	private readonly code: HTMLSpanElement;
	private readonly adresse: HTMLInputElement;
	private readonly pays: HTMLSelectElement;
	private readonly type: HTMLSelectElement;

	/**
	 * Initialize a new PlanqueTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("hideout-list") as HTMLUListElement;
		this.code = document.getElementById("hideout-details-code") as HTMLSpanElement;
		this.adresse = document.getElementById("hideout-adresse") as HTMLInputElement;
		this.pays = document.getElementById("hideout-pays") as HTMLSelectElement;
		this.type = document.getElementById("hideout-type") as HTMLSelectElement;
		this.planqueRepo = new PlanqueRepository();
		this.paysRepo = new PaysRepository();

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
			for (const planque of this.planques)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${planque.code} ${planque.adresse}`;
				this.list.append(item);

				item.setAttribute("data-id", planque.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Planque, PlanqueRepository>(
					item, planque, this.planqueRepo);
				item.append(del.button);
			}

			// Pays
			const pays = await this.paysRepo.getAll();
			for (const p of pays)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = p.libelle;
				this.pays.appendChild(item);
			}
			M.FormSelect.init(this.pays);

			// Type
			const typePlanques: Record<string, TypePlanque> = {};
			this.planques.forEach((p: Planque) => typePlanques[p.typePlanque.libelle] = p.typePlanque);
			for (const typePlanque of Object.values(typePlanques))
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = typePlanque.libelle;
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
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		this.code.innerText = this.selectedPlanque.code.toString();
		this.adresse.value = this.selectedPlanque.adresse;
		this.pays.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selectedPlanque.pays?.libelle);
		M.FormSelect.init(this.pays);
		this.type.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selectedPlanque.typePlanque?.libelle);
		M.FormSelect.init(this.type);
		console.log(this.selectedPlanque);
	}

	/**
	 * Callback on entry click.
	 * @param sender - The entry element.
	 */
	public onEntryClick(sender: HTMLLIElement): void
	{
		const idx: number = parseInt(sender.getAttribute("data-id"), 10);
		this.selectedPlanque = this.planques.find(p => p.code === idx);
		this.renderEntryView();
	}
}
