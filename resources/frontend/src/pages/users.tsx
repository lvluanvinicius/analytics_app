import { UsersFilter } from "@/components/users/users-filter";
import { UsersTable } from "@/components/users/users-table";

export function Users() {
    return (
        <div className="">
            <UsersFilter />
            <UsersTable />
        </div>
    );
}
