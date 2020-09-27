import PlanqueRepository from "../repository/PlanqueRepository";
import DeleteButton from "../component/DeleteButton";
import Planque from "../model/Planque";

export default class PlanqueTab
{
	// API Links
	private readonly planqueRepo: PlanqueRepository;

	// inputs
	private list: HTMLUListElement;

	// outputs

	/**
	 * Initialize a new PlanqueTab.
	 * @param planqueRepo
	 * @param view
	 */
	public constructor(planqueRepo: PlanqueRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.planqueRepo = planqueRepo;

		this.listAll();
	}

	/**
	 * List all planque in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const planques = await this.planqueRepo.getAll();
			// display all planques gotten from the DB
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
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
