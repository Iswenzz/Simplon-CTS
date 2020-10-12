import PlanqueRepository from "../repository/PlanqueRepository";
import DeleteButton from "../component/DeleteButton";
import Planque from "../model/Planque";
import PaysRepository from "../repository/PaysRepository";
import TypePlanque from "../model/TypePlanque";

export default class PlanqueTab
{
	private readonly planqueRepo: PlanqueRepository;
	private readonly paysRepo: PaysRepository;

	// inputs
	private readonly list: HTMLUListElement;
	private readonly adresse: HTMLInputElement;
	private readonly pays: HTMLSelectElement;
	private readonly type: HTMLSelectElement;

	/**
	 * Initialize a new PlanqueTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("hideout-list") as HTMLUListElement;
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
			const planques = await this.planqueRepo.getAll();
			for (const planque of planques)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = planque.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton<Planque, PlanqueRepository>(
					item, planque, this.planqueRepo);
				item.append(del.getButton());
			}

			// Pays
			const pays = await this.paysRepo.getAll();
			for (const p of pays)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = p.getLibelle();
				this.pays.appendChild(item);
			}
			M.FormSelect.init(this.pays);

			// Type
			const typePlanques: Record<string, TypePlanque> = {};
			planques.forEach((p: Planque) => typePlanques[p.getTypePlanque().getLibelle()] = p.getTypePlanque());
			for (const typePlanque of Object.values(typePlanques))
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = typePlanque.getLibelle();
				this.type.appendChild(item);
			}
			M.FormSelect.init(this.type);
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
