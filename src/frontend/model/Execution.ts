import Model from "./Model";

class Execution extends Model
{
	private codeMission: number;
	private codeAgent: number;

	/**
	 * Initialize a new Execution object.
	 */
	public constructor(codeMission: number, codeAgent: number)
	{
		super();
		this.codeMission = codeMission;
		this.codeAgent = codeAgent;
	}

	/**
	 * Get the value of codeAgent
	 */ 
	public getCodeAgent(): number
	{
		return this.codeAgent;
	}

	/**
	 * Set the value of codeAgent
	 */ 
	public setCodeAgent(codeAgent: number): void
	{
		this.codeAgent = codeAgent;
	}

	/**
	 * Get the value of codeMission
	 */ 
	public getCodeMission(): number
	{
		return this.codeMission;
	}

	/**
	 * Set the value of codeMission
	 *
	 * @return  self
	 */ 
	public setCodeMission(codeMission: number): void
	{
		this.codeMission = codeMission;
	}
}

export default Execution;