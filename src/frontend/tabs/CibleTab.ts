import CibleRepository from "../repository/CibleRepository";
import DeleteButton from "../component/DeleteButton";
import Cible from "../model/Cible";

export default class CibleTab
{
	// API Links
	private readonly cibleRepo: CibleRepository;

	// inputs
	private list: HTMLUListElement;

	// outputs

	/**
	 * Initialize a new CibleTab.
	 * @param cibleRepo
	 * @param view
	 */
	public constructor(cibleRepo: CibleRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.cibleRepo = cibleRepo;

		this.listAll();
	}

	/**
	 * List all cible in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const cibles = await this.cibleRepo.getAll();
			// display all cibles gotten from the DB
			for (const cible of cibles)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = cible.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton<Cible, CibleRepository>(
					item, cible, this.cibleRepo);
				item.append(del.getButton());
			}
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
