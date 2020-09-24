interface JsonSerializable
{
	jsonSerialize(): Record<string, unknown>
}

export default JsonSerializable;