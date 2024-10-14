import { useState } from "react";
import {
    Dialog,
    DialogContent,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { useLayoutEffect } from "react";
import { Button } from "@/components/ui/button";

interface SelectorProps {
    selectTitle: string;
    btnTitle: string;
    handleSearch: (search: string) => void;
    selectorValues: {
        name: string;
        value: string | number;
    }[];
    handleSelect: (value: number | string, name: string) => void;
}

export interface SelectedProps {
    value: number | string;
    name: string;
}

export function Selector({
    selectTitle,
    btnTitle,
    handleSearch,
    selectorValues,
    handleSelect,
}: SelectorProps) {
    const [open, setOpen] = useState(false);
    const [searchString, setSearchString] = useState("");

    function handleSelected(value: number | string, name: string) {
        setOpen(false);
        handleSelect(value, name);
    }

    useLayoutEffect(() => {
        handleSearch(searchString);
    }, [searchString]);

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button
                    className="!px-4 !py-2"
                    variant={"secondary"}
                    size={"sm"}
                >
                    {btnTitle}
                </Button>
            </DialogTrigger>

            <DialogContent>
                <DialogTitle className="mb-2 border-b pb-2 text-xl">
                    {selectTitle}
                </DialogTitle>
                <div className="">
                    <div className="mb-4">
                        <Input
                            type="text"
                            placeholder="Buscar"
                            onChange={(event) =>
                                setSearchString(event.currentTarget.value)
                            }
                        />
                    </div>

                    <ul className="flex h-[400px] flex-col gap-2 overflow-hidden">
                        {selectorValues.map((item) => (
                            <li
                                key={item.value}
                                className="w-full cursor-pointer rounded-md border px-2 py-2 text-muted-foreground"
                                onClick={() =>
                                    handleSelected(item.value, item.name)
                                }
                            >
                                {item.name}
                            </li>
                        ))}
                    </ul>
                </div>
            </DialogContent>
        </Dialog>
    );
}
