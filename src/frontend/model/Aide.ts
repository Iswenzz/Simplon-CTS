import Model from "./Model";

class Aide extends Model
{
	private codeMission: number;
	private codeContact: number;

	/**
	 * Initailize a new Aide object.
	 */
	public constructor(codeMission: number, codeContact: number)
	{
		super();
		this.codeMission = codeMission;
		this.codeContact = codeContact;
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
	 * Get the value of codeContact
	 */ 
	public getCodeContact(): number
	{
		return this.codeContact;
	}

	/**
	 * Set the value of codeContact
	 */ 
	public setCodeContact(codeContact: number): void
	{
		this.codeContact = codeContact;
	}
}

export default Aide;