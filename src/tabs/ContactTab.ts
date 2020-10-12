import ContactRepository from "../repository/ContactRepository";
import DeleteButton from "../component/DeleteButton";
import Contact from "../model/Contact";

export default class ContactTab
{
	// API Links
	private readonly contactRepo: ContactRepository;

	// inputs
	private list: HTMLUListElement;

	// outputs

	/**
	 * Initialize a new ContactTab.
	 * @param contactRepo
	 * @param view
	 */
	public constructor(contactRepo: ContactRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.contactRepo = contactRepo;

		this.listAll();
	}

	/**
	 * List all contact in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const contacts = await this.contactRepo.getAll();
			// display all contacts gotten from the DB
			for (const contact of contacts)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = contact.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton<Contact, ContactRepository>(
					item, contact, this.contactRepo);
				item.append(del.getButton());
			}
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
