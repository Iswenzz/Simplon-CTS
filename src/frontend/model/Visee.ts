import Model from "./Model";

class Visee extends Model
{
	private codeMission: number;
	private codeCible: number;

	/**
	 * Initailize a new Visee object.
	 */
	public constructor(codeMission: number, codeCible: number)
	{
		super();
		this.codeMission = codeMission;
		this.codeCible = codeCible;
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
	 */ 
	public setCodeMission(codeMission: number): void
	{
		this.codeMission = codeMission;
	}

	/**
	 * Get the value of codeCible
	 */ 
	public getCodeCible(): number
	{
		return this.codeCible;
	}

	/**
	 * Set the value of codeCible
	 */ 
	public setCodeCible(codeCible: number): void
	{
		this.codeCible = codeCible;
	}
}

export default Visee;