import AgentRepository from "../repository/AgentRepository";
import DeleteButton from "../component/DeleteButton";
import Agent from "../model/Agent";

export default class AgentTab
{
	// API Links
	private readonly agentRepo: AgentRepository;

	// inputs
	private list: HTMLUListElement;

	// outputs

	/**
	 * Initialize a new AgentTab.
	 * @param agentRepo
	 * @param view
	 */
	public constructor(agentRepo: AgentRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.agentRepo = agentRepo;

		this.listAll();
	}

	/**
	 * List all agent in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const agents = await this.agentRepo.getAll();
			// display all agents gotten from the DB
			for (const agent of agents)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = agent.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton<Agent, AgentRepository>(
					item, agent, this.agentRepo);
				item.append(del.getButton());
			}
		}
		catch (error)
		{
			console.log(error);
		}
	}
}
