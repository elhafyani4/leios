import { action_type } from "./actionTypes";

export const openDrawer = {
  type: action_type.OPEN_DRAWER,
  payload: true
};

export const closeDrawer = ({
  type: action_type.OPEN_DRAWER,
  payload: false
});
