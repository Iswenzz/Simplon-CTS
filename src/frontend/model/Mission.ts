import Formattable from "../Formattable";
import JsonSerializable from "../JsonSerializable";
import Model from "./Model";

class Mission extends Model implements JsonSerializable, Formattable
{
	private code: number | null;
	private titre: string;
	private description: string;
	private dateDebut: Date;
	private dateFin: Date;
	private codeStatut: number;
	private codeType: number;
	private codeSpecialite: number;

	/**
	 * Initialize a new Mission object.
	 * @param code - The mission primary key.
	 * @param titre - The mission title.
	 * @param description - The mission description.
	 * @param dateDebut - The mission start date.
	 * @param dateFin - The mission end date.
	 * @param codeStatut - The mission statut code.
	 * @param codeType - The mission type code.
	 * @param codeSpecialite - The mission speciality code.
	 */
	public constructor(code: number | null = 0, titre = "", description = "",
		dateDebut: Date = null, dateFin: Date = null, codeStatut = 0,
		codeType = 0, codeSpecialite = 0)
	{
		super();
		this.code = code;
		this.titre = titre;
		this.description = description;
		this.dateDebut = dateDebut ?? new Date();
		this.dateFin = dateFin ?? new Date();
		this.codeStatut = codeStatut;
		this.codeType = codeType;
		this.codeSpecialite = codeSpecialite;
	}

	public format(): string {
		return `${this.titre} (M${this.code})`;
	}

	/**
	 * Get the value of code
	 */ 
	public getCode(): number | null
	{
		return this.code;
	}

	/**
	 * Set the value of code
	 */ 
	public setCode(code: number | null): void
	{
		this.code = code;
	}

	/**
	 * Get the value of titre
	 */ 
	public getTitre(): string
	{
		return this.titre;
	}

	/**
	 * Set the value of titre
	 */ 
	public setTitre(titre: string): void
	{
		this.titre = titre;
	}

	/**
	 * Get the value of description
	 */ 
	public getDescription(): string
	{
		return this.description;
	}

	/**
	 * Set the value of description
	 */ 
	public setDescription(description: string): void
	{
		this.description = description;
	}

	/**
	 * Get the value of dateDebut
	 */ 
	public getDateDebut(): Date
	{
		return this.dateDebut;
	}

	/**
	 * Set the value of dateDebut
	 */ 
	public setDateDebut(dateDebut: Date): void
	{
		this.dateDebut = dateDebut;
	}

	/**
	 * Get the value of dateFin
	 */ 
	public getDateFin(): Date
	{
		return this.dateFin;
	}

	/**
	 * Set the value of dateFin
	 */ 
	public setDateFin(dateFin: Date): void
	{
		this.dateFin = dateFin;
	}

	/**
	 * Get the value of codeStatut
	 */ 
	public getCodeStatut(): number
	{
		return this.codeStatut;
	}

	/**
	 * Set the value of codeStatut
	 */ 
	public setCodeStatut(codeStatut: number): void
	{
		this.codeStatut = codeStatut;
	}

	/**
	 * Get the value of codeType
	 */ 
	public getCodeType(): number
	{
		return this.codeType;
	}

	/**
	 * Set the value of codeType
	 */ 
	public setCodeType(codeType: number): void
	{
		this.codeType = codeType;
	}

	/**
	 * Get the value of codeSpecialite
	 */ 
	public getCodeSpecialite(): number
	{
		return this.codeSpecialite;
	}

	/**
	 * Set the value of codeSpecialite
	 */ 
	public setCodeSpecialite(codeSpecialite: number): void
	{
		this.codeSpecialite = codeSpecialite;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			titre: this.getTitre(),
			description: this.getDescription(),
			dateDebut: this.getDateDebut().toLocaleDateString(),
			dateFin: this.getDateFin().toLocaleDateString(),
			codeStatut: this.getCodeStatut(),
			codeType: this.getCodeType(),
			codeSpecialite: this.getCodeSpecialite(),
		};
	}
}

export default Mission;