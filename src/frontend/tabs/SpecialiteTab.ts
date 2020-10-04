import SpecialiteRepository from "../repository/SpecialiteRepository";
import DeleteButton from "../component/DeleteButton";
import Specialite from "../model/Specialite";

export default class SpecialiteTab
{
	// API Links
	private readonly specialiteRepo: SpecialiteRepository;

	// inputs
	private list: HTMLUListElement;

	// outputs

	/**
	 * Initialize a new SpecialiteTab.
	 * @param specialiteRepo
	 * @param view
	 */
	public constructor(specialiteRepo: SpecialiteRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.specialiteRepo = specialiteRepo;

		this.listAll();
	}

	/**
	 * List all specialite in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const specialites = await this.specialiteRepo.getAll();
			// display all specialites gotten from the DB
			for (const specialite of specialites)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = specialite.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton<Specialite, SpecialiteRepository>(
					item, specialite, this.specialiteRepo);
				item.append(del.getButton());
			}
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
